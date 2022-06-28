<?php

namespace App\Controllers\Stock;

use App\Adapters\StockAdapter;
use App\Controllers\BaseController as Controller;
use App\Mails\StockSearchMail;
use App\Models\User;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class StockController extends Controller
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer =$mailer;
    }

    /**
     * @param \Slim\Psr7\Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        /** @var User $user */
        $user = $request->getAttribute('auth');

        $history = $user->stockHistory()->latest()->get();

        return $this->responseSuccess($response, $history);
    }


    /**
     * @param \Slim\Psr7\Request $request
     * @param Response $response
     * @param StockAdapter $stooqAdapter
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function show(
        Request $request,
        Response $response,
        StockAdapter $stooqAdapter): Response
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

        (new StockSearchMail($this->mailer))->sendEmail($stock,$user);

        return $this->responseSuccess($response, $stock);
    }
}
