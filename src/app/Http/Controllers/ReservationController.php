<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\ReservationConfirmed;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{

    public function create(string $slug)
    {

        $performance = Performance::where('form_url_slug', $slug)
            ->where('is_published', true)
            ->with(['troupe', 'schedules', 'ticketTypes'])
            ->firstOrFail();

        return view('reservations.create', compact('performance'));
    }

    public function store(Request $request, string $slug)
    {
        $performance = Performance::where('form_url_slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $maxLimit = $performance->max_tickets_per_person;

        $validated = $request->validate([
            'performance_schedule_id' => 'required|exists:performance_schedules,id',
            'tickets' => 'nullable|array',
            'tickets.*' => "integer|min:0|max:{$maxLimit}",
            'default_quantity' => "nullable|integer|min:1|max:{$maxLimit}",
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        $hasTicketTypes = $performance->ticketTypes()->exists();

        if ($hasTicketTypes) {
            $totalQuantity = array_sum($request->input('tickets', []));
        } else {
            $totalQuantity = (int) $request->input('default_quantity', 0);
        }

        if ($totalQuantity <= 0) {
            return back()->withErrors(['tickets' => 'チケットを1枚以上選択してください。'])->withInput();
        }

        if ($totalQuantity > $maxLimit) {
            return back()->withErrors(['tickets' => "お一人様最大 {$maxLimit} 枚までしか予約できません。"])->withInput();
        }


        $reservation = null;

        DB::transaction(function () use ($validated, $request, $hasTicketTypes, &$reservation) {

            $reservation = Reservation::create([
                'performance_schedule_id' => $validated['performance_schedule_id'],
                'reservation_token' => Str::random(64),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'reserved',
                'is_checked_in' => false,
            ]);

            if ($hasTicketTypes) {
                foreach ($request->input('tickets', []) as $ticketTypeId => $quantity) {
                    if ($quantity > 0) {
                        ReservationDetail::create([
                            'reservation_id' => $reservation->id,
                            'ticket_type_id' => $ticketTypeId,
                            'quantity' => $quantity,
                        ]);
                    }
                }
            } else {
                ReservationDetail::create([
                    'reservation_id' => $reservation->id,
                    'ticket_type_id' => null,
                    'quantity' => (int) $request->input('default_quantity'),
                ]);
            }
        });

        if ($reservation) {
            Mail::to($reservation->customer_email)->send(new ReservationConfirmed($reservation));
        }

        return redirect()->route('reservations.thanks');
    }

    public function thanks()
    {
        return view('reservations.thanks');
    }
}