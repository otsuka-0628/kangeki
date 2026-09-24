<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Performance;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index()
    {

        $performances = Performance::with('troupe')
            ->latest()
            ->paginate(20);

        return view('system.performances.index', compact('performances'));
    }

    public function destroy(Performance $performance)
    {
        $title = $performance->title;

        $performance->delete();

        return back()->with('success', "公演「{$title}」を削除しました。");
    }

}
