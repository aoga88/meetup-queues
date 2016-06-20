<?php
require_once __dir__ . "/../vendor/autoload.php";

use PhpAmqpLib\Connection\AMQPStreamConnection as QueueConnection;

$connection = new QueueConnection('192.168.10.8', 5672, 'osvaldo', 'osvaldo');
$channel = $connection->channel();
$channel->queue_declare('sdmx_queue', false, false, false, false);

print "Waiting for messages" . "\n";

$msgCallback = function($message) {
	$objMessage = json_decode($message->body);
	print "Yo soy la {$objMessage->element} {$objMessage->color}.\n";
	$message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);	
	sleep(1);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('sdmx_queue', '', false, false, false, false, $msgCallback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();