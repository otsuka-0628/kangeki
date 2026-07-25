<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // ログイン中のユーザーを取得
        $user = Auth::user();

        // ログインユーザーに紐づく劇団情報を取得
        $troupe = $user->troupe;

        // 劇団が存在する場合、その劇団の公演一覧を取得（作成日時の新しい順）
        // ※劇団がまだ登録されていない場合は空の配列にしておく
        $performances = $troupe ? $troupe->performances()->latest()->get() : collect();

        // view（home.blade.php）にデータを渡す
        return view('home', compact('troupe', 'performances'));
    }//
}
