<?php

error_reporting(0);

require_once 'vendor/autoload.php';

$channelSecret = '3b1a1321cb87a392a8c6f105f598b9c3';

$channelToken = 'BvYt6WvOyaSipaB5z0q6aMSNJlwhgZC/deUtkcbPH7k4t3PzIaquKP9/SoVFdlbjiiJO0nyrXhVHoyNt2Zfst1RQM6XghyY2ZZFmfzqj6eSM6Q84Pd0EnkGGvbrZMxjQ41gkIylbuuFghg64QCiU3gdB04t89/1O/w1cDnyilFU=';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient( $channelToken );
$bot = new \LINE\LINEBot( $httpClient, [ 'channelSecret' => $channelSecret ] );

$logger = new \Monolog\Logger('w18oonChatBot');
$logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stderr', \Monolog\Logger::DEBUG));

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

// $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

$logger->info('Postback message has come');

?>