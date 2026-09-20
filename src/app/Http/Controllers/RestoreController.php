<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class RestoreController extends Controller
{
    public function showConfirmForm(Request $request)
    {
        // セッションからメールアドレスとパスワードを取得
        $email = session('email');
        $password = session('password');

        // 直リンクやセッション切れでデータがない場合は新規登録画面へ戻す
        if (!$email || !$password) {
            return redirect()->route('user-register'); // お使いの新規登録ルート名に合わせて調整してな
        }

        // 次の画面（POST送信時）までセッションの値を保持（reflash）
        session()->keep(['email', 'password']);

        return view('restore.confirm', compact('email'));
    }

    /**
     * アカウントの復旧処理を実行
     */
    public function restore(Request $request)
    {
        $email = session('email');
        $password = session('password');

        if (!$email || !$password) {
            return redirect()->route('user-register')->with('error', 'セッションの期限が切れました。もう一度やり直してください。');
        }

        // 退会済みユーザーを検索
        $user = User::withTrashed()
            ->where('email', $email)
            ->whereNotNull('deleted_at')
            ->first();

        // ユーザーが存在し、パスワードが一致するか最終確認
        if ($user && Hash::check($password, $user->password)) {
            // 1. 論理削除を解除（データ復旧！）
            $user->restore();

            // 2. ログイン状態にする
            Auth::login($user);

            // 3. マイページやトップページへリダイレクト
            return redirect('/home')->with('message', 'アカウントを復旧してログインしました。おかえりなさい！');
        }

        // パスワードが一致しない場合（退会時のパスワードと違う場合）
        return redirect()->route('auth.user-register')->withErrors([
            'userID' => '退会時に入力されていたパスワードと一致しないため復旧できませんでした。',
        ]);
    }
}
