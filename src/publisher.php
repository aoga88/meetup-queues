<?php
require_once __dir__ . "/../vendor/autoload.php";

use PhpAmqpLib\Connection\AMQPStreamConnection as QueueConnection;
use PhpAmqpLib\Message\AMQPMessage as Message;

$connection = new QueueConnection('192.168.10.8', 5672, 'osvaldo', 'osvaldo');
$channel = $connection->channel();
$channel->queue_declare('sdmx_queue', false, false, false, false);

$colors = ['roja', 'azul', 'amarilla', 'verde', 'rosa'];
$elements = ['ficha', 'tapa'];

while(true) {
	$messagePayload = json_encode([
		'element' => $elements[rand(0, count($elements) - 1)],
		'color' => $colors[rand(0, count($colors) - 1)]
	]);

	$message = new Message($messagePayload, ['delivery_mode' => 2]);
	$channel->basic_publish($message, '', 'sdmx_queue');
	print $messagePayload . "\n";
	sleep(2);
}

$channel->close();
$connection->close();