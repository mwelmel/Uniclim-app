<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function update(Request $request)
    {
      $account = Account::find(Session::get('account_id'));

      $request->validate([
          'username' => 'required|string|max:255',
          'password' => 'nullable|string|min:6',
      ]);

      $account->username = $request->username;

      if ($request->filled('password')) {
          $account->password = Hash::make($request->password); // Enkripsi password
      }

     $account->save();

     return redirect()->back()->with('success', 'Account updated successfully!');
    }
}