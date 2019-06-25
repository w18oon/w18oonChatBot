<?php
    require_once 'vendor/autoload.php';

    $logger = new \Monolog\Logger('w18oonChatBot');
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler('logs/app.log', \Monolog\Logger::DEBUG));

    print_r($logger);
    // $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    // $logger->pushHandler(new \Monolog\Handler\StreamHandler('logs/app.log', \Monolog\Logger::DEBUG));

    // use Monolog\Logger;
    // use Monolog\Handler\StreamHandler;
    // use Monolog\Handler\FirePHPHandler;

    // $logger = new Logger('w18oonChatBot');
    // $logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
?>