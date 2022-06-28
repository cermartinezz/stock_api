<?php

use DI\ContainerBuilder;

return function(ContainerBuilder $containerBuilder) {
    // Initialize app with PHP-DI
    $container = $containerBuilder->build();

    $container->set('db', config('settings.db'));
    $container->set(\App\Adapters\StockAdapter::class, new \App\Adapters\StooqAdapter());

    return $container;
};

