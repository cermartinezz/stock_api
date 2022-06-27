<?php

namespace App\Controllers;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{
    /**
     * @param Response $response
     * @param $data
     * @return Response
     */
    public function responseSuccess(Response $response, $data): Response
    {
        return $this->json($response, $data, StatusCodeInterface::STATUS_OK);
    }

    /**
     * @param Response $response
     * @param $data
     * @return Response
     */
    public function responseBadRequest(Response $response, $data): Response
    {
        return $this->json($response, $data, StatusCodeInterface::STATUS_BAD_REQUEST);
    }

    public function json(Response $response, $data, $statusCode = StatusCodeInterface::STATUS_OK): Response
    {
        $data = json_encode($data);

        $response = $response->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);

        $response->getBody()->write($data);

        return $response;
    }
}
