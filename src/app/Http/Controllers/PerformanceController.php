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
            // 'is_published' => 'required|boolean',
        ]);

        $schedulesDate = $validated['schedules'] ?? [];
        unset($validated['schedules']);

        $troupe = Auth::user()->troupe;
        if (!$troupe) {
            return redirect()->back->withError(['error' => '先に劇団情報を登録してください。']);
        }

        $validated['troupe_id'] = $troupe ? $troupe->id : null;
        $validated['is_published'] = true;
        $validated['form_url_slug'] = Str::random(10);

        $performance = Performance::create($validated);

        // if (!empty($schedulesDate)) {
        //     foreach ($schedulesDate as $schedule) {
        //         if (!empty($schedule['start_time'])) {
        //             $performance->schedules()->create([
        //                 'start_time' => $schedule['start_time'],
        //             ]);
        //         }
        //     }
        // }

        return redirect()->route('home')->with('success', '公演情報を登録しました。');
    }
}
