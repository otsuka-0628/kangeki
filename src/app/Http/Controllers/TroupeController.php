<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Troupe;

class TroupeController extends Controller
{
    public function show()
    {
        $troupe = Auth::user()->troupe;
        return view('troupes.show', compact('troupe'));
    }

    public function edit()
    {
        $troupe = Auth::user()->troupe;

        // 都道府県のリスト
        $prefectures = [
            '北海道',
            '青森県',
            '岩手県',
            '宮城県',
            '秋田県',
            '山形県',
            '福島県',
            '茨城県',
            '栃木県',
            '群馬県',
            '埼玉県',
            '千葉県',
            '東京都',
            '神奈川県',
            '新潟県',
            '富山県',
            '石川県',
            '福井県',
            '山梨県',
            '長野県',
            '岐阜県',
            '静岡県',
            '愛知県',
            '三重県',
            '滋賀県',
            '京都府',
            '大阪府',
            '兵庫県',
            '奈良県',
            '和歌山県',
            '鳥取県',
            '島根県',
            '岡山県',
            '広島県',
            '山口県',
            '徳島県',
            '香川県',
            '愛媛県',
            '高知県',
            '福岡県',
            '佐賀県',
            '長崎県',
            '熊本県',
            '大分県',
            '宮崎県',
            '鹿児島県',
            '沖縄県'
        ];

        return view('troupes.edit', compact('troupe', 'prefectures'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'representative_name' => 'nullable|string|max:255',
            'prefecture' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => '劇団名は必須入力です。',
            'prefecture.required' => '活動拠点（都道府県）を選択してください。',
        ]);

        Auth::user()->troupe()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'name' => $request->name,
                'representative_name' => $request->representative_name,
                'prefecture' => $request->prefecture,
                'description' => $request->description,
            ]
        );

        return redirect()->route('troupe.show')->with('success', '劇団情報を保存しました。');
    }
}