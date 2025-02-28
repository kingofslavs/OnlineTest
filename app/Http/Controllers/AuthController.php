<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'h-captcha-response' => 'required|hcaptcha',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'h-captcha-response' => 'required|hcaptcha',
        ]);

        $loginCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($loginCredentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function profile()
    {
        return view('profile');
    }

    public function passwordChange(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors([
                'current_password' => 'Текущий пароль введен неверно',
            ]);
        }

        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('profile')->with('success', 'Пароль успешно изменен');
    }

    public function nameChange(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $validated['name'];
        $user->save();

        return redirect()->route('profile')->with('success', 'Имя успешно изменено');
    }
}
