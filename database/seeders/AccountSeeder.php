<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $usernames = ['Chandra', 'Angelique', 'Tommy', 'Thomas', 'Dept.Head', 'Marketing', 'Admin'];

        foreach ($usernames as $username) {
            Account::create([
                'username' => $username,
                'password' => Hash::make('UGS.123'),
            ]);
        }
    }
}
