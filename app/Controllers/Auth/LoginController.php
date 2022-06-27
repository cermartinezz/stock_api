<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController as Controller;
use App\Request\LoginRequest;
use App\Traits\Authenticator;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;


class LoginController extends Controller
{
    use Authenticator;

    public function login(Request $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();

        $validator = (new LoginRequest())->validate($data);

        if($validator->isNotValid()){
            return $this->responseErrorValidation($response, $validator->errors());
        }

        ['email'=>$email,'password'=>$password] = $data;

        $token = $this->authenticateUser($email, $password);

        if(empty($token)){
            return $this->responseBadRequest($response, ['message' => "Email or password are invalid"], 400);
        }

        return $this->responseSuccess($response, $token);
    }
}
