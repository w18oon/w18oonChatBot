<?php

date_default_timezone_set("Asia/Bangkok");

require_once 'vendor/autoload.php';

$channelSecret = '3b1a1321cb87a392a8c6f105f598b9c3';

$channelToken = 'BvYt6WvOyaSipaB5z0q6aMSNJlwhgZC/deUtkcbPH7k4t3PzIaquKP9/SoVFdlbjiiJO0nyrXhVHoyNt2Zfst1RQM6XghyY2ZZFmfzqj6eSM6Q84Pd0EnkGGvbrZMxjQ41gkIylbuuFghg64QCiU3gdB04t89/1O/w1cDnyilFU=';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient( $channelToken );
$bot = new \LINE\LINEBot( $httpClient, [ 'channelSecret' => $channelSecret ] );

$logger = new \Monolog\Logger( 'w18oonChatBot' );
$logger->pushProcessor( new \Monolog\Processor\UidProcessor() );
$logger->pushHandler( new \Monolog\Handler\StreamHandler( 'logs/app.log' , \Monolog\Logger::DEBUG ) );

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

// get request
try {
	$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch ( \LINE\LINEBot\Exception\InvalidSignatureException $e ) {
    $logger->err( 'InvalidSignatureException' );
} catch ( \LINE\LINEBot\Exception\InvalidEventRequestException $e ) {
    $logger->err( 'InvalidEventRequestException' );
}

foreach ( $events as $event ) {
    // get text from sender
    $replyText = $event->getText();
    $logger->info('Reply text: ' . $replyText);

    // reply with same text
    $response = $bot->replyText($event->getReplyToken(), $replyText);

    //logging reponse
    $logger->info($response->getHTTPStatus() . ': ' . $response->getRawBody());

    // $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder( 'text message' );
    // $response = $bot->replyMessage( $event->getReplyToken() , $outputText );

    http_response_code(200);
}  

?>