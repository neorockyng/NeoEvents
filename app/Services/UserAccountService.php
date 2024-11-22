<?php

namespace App\Services;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAccountService
{
    public function createUserAndLogin($orderData)
    {
        // Generate a secure, random password
        $password = Str::random(10);

        // Create the account
        $accountData = [
            'email' => $orderData['email'],
            'first_name' => $orderData['first_name'],
            'last_name' => $orderData['last_name'],
            'currency_id' => config('attendize.default_currency'),
            'timezone_id' => config('attendize.default_timezone')
        ];
        $account = Account::create($accountData);

        // Create the user
        $user = User::create([
            'email' => $orderData['email'],
            'first_name' => $orderData['first_name'],
            'last_name' => $orderData['last_name'],
            'password' => Hash::make($password),
            'account_id' => $account->id,
            'is_parent' => 1,
            'is_registered' => 1
        ]);

        return $userData = ['user' => $user, 'account' => $account];
    }
}
