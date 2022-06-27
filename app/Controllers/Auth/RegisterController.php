<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\User;
use App\Request\RegisterRequest;
use App\Traits\Authenticator;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;

class RegisterController extends BaseController
{
    use Authenticator;

    public function register(Request $request, ResponseInterface $response)
    {
        $data = $request->getParsedBody();

        [
            'email'         => $email,
            'password'      => $password,
            'first_name'    => $firstName,
            'last_name'     => $lastName
        ] = $data;

        $userExists = User::query()->where('email',$email)->exists();

        if($userExists)  return $this->responseErrorValidation($response,['email' => ['email' => "The email is already been taken"]]);

        $validator = (new RegisterRequest())->validate($data);

        if($validator->isNotValid()) {
            return $this->responseErrorValidation($response,$validator->errors());
        }

        $user = User::create($data);

        $token = $this->createToken($user);

        return $this->responseCreated($response, ['user' => $user, 'token' => $token]);

    }
}
