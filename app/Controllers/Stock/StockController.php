<?php

namespace App\Controllers\Stock;

use App\Adapters\StockAdapter;
use App\Controllers\BaseController as Controller;
use App\Models\User;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class StockController extends Controller
{
    /**
     * @param \Slim\Psr7\Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        /** @var User $user */
        $user = $request->getAttribute('auth');

        $history = $user->stockHistory()->get();

        return $this->responseSuccess($response, $history);
    }


    /**
     * @param \Slim\Psr7\Request $request
     * @param Response $response
     * @param StockAdapter $stooqAdapter
     * @return Response
     */
    public function show(Request $request, Response $response, StockAdapter $stooqAdapter): Response
    {
        /** @var User $user */
        $user = $request->getAttribute('auth');
        $data = $request->getQueryParams();

        if(empty($data)){
            return $this->responseBadRequest($response, ['message' => 'No commodity code was provided']);
        }

        $code = $data['q'];

        $stock = $stooqAdapter->getStock($code);
        $stock->user_id = $user->id;
        $stock->save();

        return $this->responseSuccess($response, $stock);
    }
}
