<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationDetail;
use App\Models\PerformanceSchedule;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Performance;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['schedule.performance', 'details.ticketType'])
            ->orderBy('created_at', 'desc');

        if ($request->has('performance_id') && $request->performance_id != '') {
            $query->whereHas('schedule', function ($q) use ($request) {
                $q->where('performance_id', $request->performance_id);
            });
        }

        if ($request->has('schedule_id') && $request->schedule_id != '') {
            $query->where('performance_schedule_id', $request->schedule_id);
        }

        $reservations = $query->paginate(20);

        return view('admin.reservations.index', compact('reservations'));
    }


    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);


        if ($reservation->status === 'cancelled') {
            return back()->with('error', 'すでにキャンセルされている予約です。');
        }


        $reservation->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', '予約をキャンセルしました。残席数が復元されました。');
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::with(['details', 'schedule'])->findOrFail($id);

        $request->validate([
            'tickets' => 'required|array',
            'tickets.*' => 'integer|min:0',
        ]);

        $newTotalTickets = array_sum($request->tickets);

        if ($newTotalTickets <= 0) {
            return back()->with('error', '予約枚数は合計1枚以上にしてください（取り消す場合はキャンセルボタンを使用してください）。');
        }

        $currentTotalTickets = $reservation->details->sum('quantity');

        if ($newTotalTickets > $currentTotalTickets) {
            $addedTickets = $newTotalTickets - $currentTotalTickets;

            $schedule = PerformanceSchedule::with('performance')->findOrFail($reservation->performance_schedule_id);
            $reservedCount = Reservation::where('performance_schedule_id', $schedule->id)
                ->where('status', '!=', 'cancelled')
                ->where('id', '!=', $reservation->id) // 自分自身の今の予約は除く
                ->withSum('details', 'quantity')
                ->get()
                ->sum('details_sum_quantity');

            $remainingSeats = $schedule->capacity - $reservedCount;

            if ($remainingSeats < $newTotalTickets) {
                return back()->with('error', '残席数が足りないため、枚数を増やすことができません。（現在の残席枠: ' . $remainingSeats . '枚）');
            }
        }

        DB::transaction(function () use ($reservation, $request) {

            $reservation->details()->delete();

            foreach ($request->tickets as $ticketTypeId => $quantity) {
                if ($quantity > 0) {
                    ReservationDetail::create([
                        'reservation_id' => $reservation->id,
                        'ticket_type_id' => $ticketTypeId,
                        'quantity' => $quantity,
                    ]);
                }
            }
        });

        return back()->with('success', '予約内容を変更しました。');
    }


    public function export(Request $request, Performance $performance): StreamedResponse
    {

        $query = Reservation::with(['schedule', 'details.ticketType'])
            ->join('performance_schedules', 'reservations.performance_schedule_id', '=', 'performance_schedules.id')->where('performance_schedules.performance_id', $performance->id)
            ->orderBy('performance_schedules.start_at', 'asc')
            ->orderBy('reservations.created_at', 'asc')
            ->select('reservations.*');


        if ($request->filled('schedule_id')) {
            $query->where('reservations.performance_schedules_id', $request->schedule_id);
        }

        $reservations = $query->get();


        $title = str_replace(['/', '\\', ' ', ' '], '_', $performance->title ?? 'performance');

        $fileName = '予約リスト_' . $title . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($reservations) {
            $stream = fopen('php://output', 'w');


            fwrite($stream, "\xEF\xBB\xBF");


            fputcsv($stream, ['予約ID', 'ステータス', '公演日時', 'お名前', 'メールアドレス', '電話番号', 'チケット内訳', '合計枚数', '合計金額', '備考']);


            foreach ($reservations as $r) {

                $ticketDetails = $r->details->map(function ($d) {
                    return ($d->ticketType->name ?? 'チケット') . '×' . $d->quantity . '枚';
                })->implode(' / ');

                $totalAmount = $r->details->sum(function ($d) {
                    return $d->quantity * ($d->ticketType->price ?? 0);
                });

                $statusText = match ($r->status) {
                    'cancelled' => 'キャンセル済み',
                    'reserved' => '予約完了',
                    default => $r->status,
                };

                fputcsv($stream, [
                    $r->id,
                    $statusText,
                    $r->schedule->start_at ? $r->schedule->start_at->format('Y/m/d H:i') : '',
                    $r->customer_name,
                    $r->customer_email,
                    $r->customer_phone ?? '',
                    $ticketDetails,
                    $r->details->sum('quantity') . '枚',
                    number_format($totalAmount) . '円',
                    $r->notes ?? '',
                ]);
            }

            fclose($stream);
        };

        return response()->stream($callback, 200, $headers);
    }
}
