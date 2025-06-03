<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $account = Account::where('username', $request->username)->first();

        if ($account && Hash::check($request->password, $account->password)) {
            Auth::login($account); // Gunakan Auth bawaan Laravel
            return redirect('/dashboard');
        } else {
            return back()->withErrors(['Username atau password salah.']);
        }
    }

    public function accountPage()
    {
        $account = auth()->user(); // Ambil data user yang sedang login
        return view('account', compact('account'));
    }

    public function updateAccount(Request $request)
    {
        $account = auth()->user(); // Ambil data user yang sedang login

        $request->validate([
            'username' => 'required|unique:accounts,username,' . $account->id,
            'password' => 'nullable|min:6',
        ]);

        $account->username = $request->username;

        if ($request->filled('password')) {
            $account->password = Hash::make($request->password);
        }

        $account->save();

        return redirect('/dashboard')->with('success', 'Data akun berhasil diperbarui.');
    }
}