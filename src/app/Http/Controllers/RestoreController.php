<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\RestoreAccountMail;

class RestoreController extends Controller
{
    public function showConfirmForm()
    {
        $email = session('email');
        if (!$email) {
            return redirect()->route('register');
        }
        session()->keep(['email']);

        return view('restore.confirm', compact('email'));
    }

    public function sendRestoreMail(Request $request)
    {
        $email = session('email');
        if (!$email) {
            return redirect()->route('register')->with('error', 'セッションが無効です。最初からやり直してください。');
        }

        $user = User::withTrashed()
            ->where('email', $email)
            ->whereNotNull('deleted_at')
            ->first();

        if (!$user) {
            return redirect()->route('register');
        }


        $restoreUrl = URL::temporarySignedRoute(
            'restore.verify',
            now()->addHours(24),
            ['id' => $user->id]
        );


        Mail::to($user->email)->send(new RestoreAccountMail($user, $restoreUrl));

        return view('restore.sent', ['email' => $email]);
    }

    public function verifyAndRestore(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            $user->restore();
        }

        Auth::login($user);

        return redirect('/home')->with('message', 'メール認証が完了し、アカウントを復旧しました。おかえりなさい！');
    }
}
