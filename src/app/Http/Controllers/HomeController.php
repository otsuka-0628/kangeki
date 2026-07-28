<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Performance;

class HomeController extends Controller
{
    public function index()
    {
        // ログイン中のユーザー（劇団）を取得
        $user = Auth::user();

        // ログイン中の劇団に関連する公演データ（予約状況付き）を取得
        //※TroupeとPerformanceのリレーション、PerformanceとScheduleのリレーションを活用します
        $performances = Performance::where('troupe_id', $user->troupe_id ?? null)
            ->with('schedules')//関連する公演スケジュールも一緒に取得
            ->get();


        // view（home.blade.php）にデータを渡す
        return view('home', compact('performances'));
    }//
}
