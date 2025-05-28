<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    public function run()
    {
        Account::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
