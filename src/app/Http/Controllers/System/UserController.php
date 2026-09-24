<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function toggleBlock(User $user)
    {

        if ($user->role === 'admin') {
            return back()->with('error', '管理者アカウントを停止することはできません。');
        }

        $user->is_suspended = !$user->is_suspended;
        $user->save();

        $displayName = $user->troupe?->name ?: $user->email;

        $message = $user->is_suspended
            ? "{$displayName} のアカウントを停止しました。"
            : "{$displayName} のアカウント停止を解除しました。";

        return back()->with('success', $message);
    }

    public function index()
    {
        $users = User::where('role', '!=', 'admin')
            ->with('troupe')
            ->latest()
            ->paginate(20);

        return view('system.users.index', compact('users'));
    }

}
