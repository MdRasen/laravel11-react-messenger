<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:' . User::class],
            'is_admin' => ['boolean'],
        ]);

        // generate and assign random password
        $rawPassword = Str::random(8);
        $data['password'] = bcrypt($rawPassword);
        $data['email_verified_at'] = now();

        User::create($data);

        return redirect()->back();
    }

    public function changeRole(User $user)
    {
        $user->update(['is_admin' => !(bool) $user->is_admin]);

        $message = "User role changed to " . ($user->is_admin ? 'admin' : 'user');

        return redirect()->json(['message' => $message]);
    }

    public function blockUnblock(User $user)
    {
        if ($user->is_blocked) {
            $user->blocked_at = null;
            $message = "User unblocked";
        } else {
            $user->blocked_at = now();
            $message = "User blocked";
        }

        $user->save();

        return redirect()->json(['message' => $message]);
    }
}
