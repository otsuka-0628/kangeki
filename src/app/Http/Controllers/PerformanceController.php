<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PerformanceController extends Controller
{
    public function create()
    {
        return view('performances.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'sub_title' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'max_tickets_per_person' => 'required|integer|min:1',
            'end_of_reservation_at' => 'required|date',
            'notes' => 'nullable|array',
            'schedules' => 'nullable|array',
            'schedules.*.start_time' => 'nullable|string',
        ]);

        $troupe = Auth::user()->troupe;

        $validated['troupe_id'] = $troupe ? $troupe->troupe_id : null;
        $validated['is_published'] = true;
        $performance = Performance::create($validated);

        return redirect()->route('home')->with('success', '公演情報を登録しました。');
    }
}
