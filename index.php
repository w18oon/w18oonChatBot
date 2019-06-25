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

try {
	$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch( \LINE\LINEBot\Exception\InvalidSignatureException $e ) {
    $logger->err( 'parseEventRequest failed. InvalidSignatureException => '.var_export( $e , true ) );
} catch( \LINE\LINEBot\Exception\UnknownEventTypeException $e ) {
    $logger->err( 'parseEventRequest failed. UnknownEventTypeException => '.var_export( $e , true ) );
} catch( \LINE\LINEBot\Exception\UnknownMessageTypeException $e ) {
    $logger->err( 'parseEventRequest failed. UnknownMessageTypeException => '.var_export( $e , true ) );
} catch( \LINE\LINEBot\Exception\InvalidEventRequestException $e ) {
    $logger->err( 'parseEventRequest failed. InvalidEventRequestException => '.var_export( $e , true ) );
}

foreach ( $events as $event ) {
    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder( 'text message' );
    $response = $bot->replyMessage( $event->getReplyToken() , $outputText );
    if ( $response->isSucceeded() ) {
        echo 'Succeeded!';
        return;
    }
    
    // Failed
    echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

	// Message Event = TextMessage
	// if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
	// 	$messageText=strtolower(trim($event->getText()));
	// 	switch ($messageText) {
	// 	case "text" : 
	// 		$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("text message");
	// 		break;
	// 	case "location" :
	// 		$outputText = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder("Eiffel Tower", "Champ de Mars, 5 Avenue Anatole France, 75007 Paris, France", 48.858328, 2.294750);
	// 		break;
	// 	case "button" :
	// 		$actions = array (
	// 			// general message action
	// 			New \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder("button 1", "text 1"),
	// 			// URL type action
	// 			New \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("Google", "http://www.google.com"),
	// 			// The following two are interactive actions
	// 			New \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("next page", "page=3"),
	// 			New \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Previous", "page=1")
	// 		);
	// 		$img_url = "https://cdn.shopify.com/s/files/1/0379/7669/products/sampleset2_1024x1024.JPG?v=1458740363";
	// 		$button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("button text", "description", $img_url, $actions);
	// 		$outputText = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("this message to use the phone to look to the Oh", $button);
	// 		break;
	// 	case "carousel" :
	// 		$columns = array();
	// 		$img_url = "https://cdn.shopify.com/s/files/1/0379/7669/products/sampleset2_1024x1024.JPG?v=1458740363";
	// 		for($i=0;$i<5;$i++) {
	// 			$actions = array(
	// 				new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Add to Card","action=carousel&button=".$i),
	// 				new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("View","http://www.google.com")
	// 			);
	// 			$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Title", "description", $img_url , $actions);
	// 			$columns[] = $column;
	// 		}
	// 		$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
	// 		$outputText = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("Carousel Demo", $carousel);
	// 		break;	
	// 	case "image" :
	// 		$img_url = "https://cdn.shopify.com/s/files/1/0379/7669/products/sampleset2_1024x1024.JPG?v=1458740363";
	// 		$outputText = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
	// 		break;	
	// 	case "confirm" :
	// 		$actions = array (
	// 			New \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("yes", "ans=y"),
	// 			New \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("no", "ans=N")
	// 		);
	// 		$button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder("problem", $actions);
	// 		$outputText = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("this message to use the phone to look to the Oh", $button);
	// 		break;
	// 	default :
	// 		$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("demo command: text, location, button, confirm to test message template");	
	// 		break;
	// 	}
	// 	$response = $bot->replyMessage($event->getReplyToken(), $outputText);
	// }
}  

?>