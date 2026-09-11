<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['schedule.performance', 'details.ticketType'])
            ->orderBy('created_at', 'desc');

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
}
