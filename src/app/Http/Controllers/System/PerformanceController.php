<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Performance;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index()
    {

        $performances = Performance::withTrashed()
            ->with('troupe')
            ->latest()
            ->paginate(20);

        return view('system.performances.index', compact('performances'));
    }

    public function togglePublish($id)
    {
        $performance = Performance::withTrashed()->findOrFail($id);

        if ($performance->trashed()) {

            $performance->restore();
            $message = "公演「{$performance->title}」の公開停止を解除しました。";
        } else {

            $performance->delete();
            $message = "公演「{$performance->title}」を公開停止しました。";
        }

        return back()->with('success', $message);
    }

}
