<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController as Controller;
use App\Traits\Authenticator;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;


class LoginController extends Controller
{
    use Authenticator;

    public function login(Request $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();

        $email = $data['email'];
        if (! isset($email)) {
            throw new \Exception('The field "email" is required.', 400);
        }
        $password = $data['password'];
        if (! isset($password)) {
            throw new \Exception('The field "password" is required.', 400);
        }

        $token = $this->authenticateUser($email, $password);

        if(empty($token)){
            return $this->responseBadRequest($response, ['message' => "Email or password are invalid"], 400);
        }

        return $this->responseSuccess($response, $token);
    }
}
