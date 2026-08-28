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
            'schedules.*.start_at' => 'nullable|string',
            // 'is_published' => 'required|boolean',
        ]);

        $schedulesDate = $validated['schedules'] ?? [];
        unset($validated['schedules']);

        $troupe = Auth::user()->troupe;
        if (!$troupe) {
            return back()->withErrors(['先に劇団情報を登録してください。']);
        }

        $validated['troupe_id'] = $troupe ? $troupe->id : null;
        $validated['is_published'] = true;
        $validated['form_url_slug'] = Str::random(10);

        $performance = Performance::create($validated);

        if (!empty($schedulesDate)) {
            foreach ($schedulesDate as $schedule) {
                if (!empty($schedule['start_at'])) {
                    $performance->schedules()->create([
                        'start_at' => $schedule['start_at'],
                        'capacity' => $schedule['capacity'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('home')->with('success', '公演情報を登録しました。');
    }

    public function detail($id)
    {
        $performance = Performance::findOrFail($id);

        return view('performances.detail', compact('performance'));
    }



    public function edit($id)
    {
        $performance = Performance::findOrFail($id);
        return view('performances.edit', compact('performance'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sub_title' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'max_tickets_per_person' => 'required|integer|min:1',
            'end_of_reservation_at' => 'required|date',
            'notes' => 'nullable|array',
            'schedules' => 'nullable|array',
            'schedules.*.start_at' => 'nullable|string',
        ]);

        $performance = Performance::findOrFail($id);

        $schedulesData = $validated['schedulas'] ?? [];
        unset($validated['schedules']);

        $performance->update($validated);

        if (!empty($schedulesData)) {
            foreach ($schedulesData as $schedule) {
                if (!empty($schedule['start_at'])) {
                    $performance->schedules()->create([
                        'start_at' => $schedule['start_at'],
                        'capacity' => $schedule['capacity'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('performances.detail', $performance->id)->with('success', '公演情報を更新しました。');
    }

    public function destroy($id)
    {

        $performance = Performance::findOrFail($id);
        $performance->delete();
        return redirect()->route('home')->with('success', '公演を削除しました。');
    }
}
