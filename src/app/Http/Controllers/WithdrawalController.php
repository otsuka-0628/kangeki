<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function confirm()
    {
        $user = Auth::user();

        $hasUpcomingEvents = false;

        if ($user->troupe) {

            $hasUpcomingEvents = $user->troupe->performances()
                ->where('end_of_reservation_at', '>=', now())
                ->exists();
        }

        return view('withdrawal.confirm', compact('hasUpcomingEvents'));
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        $user->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', '退会手続きが完了しました。ご利用ありがとうございました。');
    }

}
