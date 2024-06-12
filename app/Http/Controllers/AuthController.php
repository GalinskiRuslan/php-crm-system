<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = $request->validate([
            'phone' => 'required|string|max:10|min:10',
            'password' => 'required|string',
        ]);

        $user = User::where('phone', $validate['phone'])->first();
        if ($user && Hash::check($validate['password'], $user->password)) {
            Auth::login($user);
            return redirect('/');
        } else {
            return back()->withErrors(['phone' => 'Неверный  телефон или пароль'])->withInput($validate);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
