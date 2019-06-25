<?php

require_once 'vendor/autoload.php';

$channelAccessToken = 'FHSGmy/OcieflUXOhLmeKbUWEJl9/47QdZjAg7Sybl2sVnDsSYlERzQ3jU557TZviiJO0nyrXhVHoyNt2Zfst1RQM6XghyY2ZZFmfzqj6eTVXitYhcGj9ndij03yh3wBZqW5rNcYpVlQhN9oOlgZtAdB04t89/1O/w1cDnyilFU=';
$channelSecret = '68cf1b782ae45b6b0847ce8b9c0ae331';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

foreach ($events as $event) {
	// Message Event = TextMessage
	if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
        $messageText = strtolower(trim($event->getText()));
        $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("text message");
		$response = $bot->replyMessage($event->getReplyToken(), $outputText);
	}
}