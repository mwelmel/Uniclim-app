<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $account = Account::where('username', $request->username)->first();

        if ($account && Hash::check($request->password, $account->password)) {
            Session::put('account_id', $account->id);
            return redirect('/dashboard');
        } else {
            return back()->withErrors(['Username atau password salah.']);
        }
    }

    public function accountPage()
    {
        $account = Account::find(Session::get('account_id'));
        return view('account', compact('account'));
    }

    public function updateAccount(Request $request)
    {
        $account = Account::find(Session::get('account_id'));

        $request->validate([
            'username' => 'required|unique:accounts,username,' . $account->id,
            'password' => 'nullable|min:6',
        ]);

        $account->username = $request->username;
        if ($request->filled('password')) {
            $account->password = Hash::make($request->password);
        }

        $account->save();

        // Redirect langsung ke dashboard setelah update berhasil
        return redirect('/dashboard')->with('success', 'Data akun berhasil diperbarui.');
    }
}
