<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Performance;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $performances = Performance::where('troupe_id', $user->troupe_id ?? null)
            ->with('schedules')
            ->get();



        return view('home', compact('performances'));
    }//
}
