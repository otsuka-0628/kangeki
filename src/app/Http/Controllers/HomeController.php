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

        $troupe = $user->troupe;

        $performances = $troupe
            ? Performance::where('troupe_id', $troupe->id)->get()
            : collect();



        return view('home', compact('performances'));
    }//
}
