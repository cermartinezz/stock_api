<?php

namespace App\Mails;

use App\Models\StockHistory;
use App\Models\User;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class StockSearchMail
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(StockHistory $stock, User $user): void
    {
        $email = (new Email())
            ->from('market@stock.com')
            ->to($user->email)
            ->subject("Information about $stock->name in the market on $stock->date")
            ->html("
                <p>Information about $stock->name - <b>$stock->symbol</b></p>
                <p>Open: <b>$stock->open</b></p>
                <p>Close: <b>$stock->close</b></p>
                <p>High: <b>$stock->high</b></p>
                <p>Low: <b>$stock->low</b></p>
            ");

        $this->mailer->send($email);
    }
}
