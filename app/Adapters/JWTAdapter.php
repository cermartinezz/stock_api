<?php

namespace App\Adapters;

use App\Models\User;
use Firebase\JWT\JWT;

class JWTAdapter
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var array
     */
    private $claims;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->claims = [];
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->setUserClaims()
            ->createToken();
    }

    /**
     * @param array $data
     * @return void
     */
    public function setClaim(array $data)
    {
        $this->claims = array_merge($this->claims,$data);
    }

    /**
     * @return JWTAdapter
     */
    private function setUserClaims(): JWTAdapter
    {
        $this->claims = [
            'sub'   => $this->user->id,
            'email' => $this->user->email,
            'name'  => $this->user->first_name,
            'iat'   => time(),
            'exp'   => time() + config('settings.jwt.token_lifetime'),
        ];

       return $this;
    }

    /**
     * @return string
     */
    private function createToken(): string
    {
        return JWT::encode($this->claims, env('APP_KEY'));
    }
}
