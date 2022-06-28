<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([

        // SMTP transport
        MailerInterface::class => function () {
            $settings = config('settings.smtp');

            $dsn = sprintf(
                '%s://%s:%s@%s:%s',
                $settings['type'],
                $settings['username'],
                $settings['password'],
                $settings['host'],
                $settings['port']
            );

            return new Mailer(Transport::fromDsn($dsn));
        },
    ]);

};
