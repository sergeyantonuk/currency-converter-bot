<?php

namespace App\Http\Services;

use App\Chat;
use App\User;

class UsersService
{
    public function __construct()
    {
    }

    public function createUser($telegramUserId, $username, $firstName)
    {
        $user = new User();
        $user->telegramUserId = $telegramUserId;
        $user->username = $username;
        $user->firstName = $firstName;

        $user->save();

        return $user;
    }

    public function getUserByTelegramUserId($telegramId)
    {
        return User::where('telegram_user_id', $telegramId)->first();
    }
}