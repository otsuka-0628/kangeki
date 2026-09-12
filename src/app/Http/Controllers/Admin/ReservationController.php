<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationDetail;
use App\Models\PerformanceSchedule;
use Illuminate\Support\Facades\DB;

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
}
