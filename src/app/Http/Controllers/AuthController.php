<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Weight_target;
use App\Models\Weight_log;
use Illuminate\Support\Facades\Route;


class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        if (Route::currentRouteName() === 'register/step1') {
            return view('auth.register_step1');
        }

        if (Route::currentRouteName() === 'register/step2') {
            return view('auth.register_step2');
        }
    }


    public function register_step1(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        Auth::login($user);

        return redirect()->route('register/step2');
    }

    public function register_step2(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:1|max:500',
            'target_weight' => 'required|numeric|min:1|max:500',
        ]);

        $user = Auth::user();

        if ($user) {
            Weight_target::create([
                'user_id' => $user->id,
                'target_weight' => $request->input('target_weight'),
            ]);

            Weight_log::create([
                'user_id' => $user->id,
                'weight' => $request->input('weight'),
                'date' => now()->format('Y-m-d'),
            ]);
        } else {
            return redirect()->route('register/step1')->withErrors(['message' => 'セッションが切れました。最初から登録をやり直してください。']);
        }

        return redirect('/weight_logs')->with('success', 'ユーザー登録と体重目標の設定が完了しました！');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/weight_logs');
        }

        return back()->withErrors([
            'email' => '入力された認証情報が記録と一致しません。',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
