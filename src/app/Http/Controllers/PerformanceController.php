<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PerformanceController extends Controller
{
    //公演の新規登録画面を表示する
    public function create()
    {
        //単に'Performances.create'というviewを表示する
        return view('performances.create');
    }

    //フォームから送信された公演データをデータベースに保存する
    public function store(Request $request)
    {
        //入力チェック（バリデーション）
        $validated = $request->validate([
            'sub_title' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'max_tickets_per_person' => 'required|interger|min:1',
            'end_of_reservation_at' => 'required|date',
            'notes' => 'nullable|array',

            //公演日時（複数入力される想定）のバリデーション
            'schedules' => 'nullable|array',
            'schedules.*.start_time' => 'nullable|string',
        ]);

        //ログインユーザーの劇団IDをセット
        $user = Auth::user()->troupe;

        $validated['troupe_id'] = $user->troupe_id ?? null;
        $validated['is_published'] = true; // デフォルトで公開状態にしておく

        //公演（Performance）本体を保存
        $performance = Performance::create($validated);

        // 3. 公演日時（Schedules）があれば一緒に保存
        if (!empty($request->schedules)) {
            foreach ($request->schedules as $scheduleData) {
                // 公演IDを紐付けて保存
                $performance->schedules()->create([
                    'performance_date' => $scheduleData['performance_date'],
                    'start_time' => $scheduleData['start_time'],
                ]);
            }
        }

        // 4. 保存が終わったらホーム画面に戻り、メッセージを表示！
        return redirect()->route('home')->with('success', '公演情報を登録しました。');
    }
}
