<?php

namespace App\Traits;

use App\Adapters\JWTAdapter;
use App\Models\User;

trait Authenticator
{
    public function authenticateUser($email, $password): array
    {
        /** @var User $user */
        $user = User::query()->where('email', $email)->firstOrFail();

        if(!$this->validatePassword($password, $user->password)){
            return [];
        }

        $token = (new JWTAdapter($user))->getToken();

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * @param $password
     * @param $hashedPassword
     * @return bool
     */
    public function validatePassword($password, $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}
