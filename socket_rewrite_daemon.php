<?php
require "vendor/autoload.php";

ignore_user_abort(true);
set_time_limit(0);

$txleng = 160;
$rxleng = 160;

$sock1 = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

$socket_RX = stream_socket_client("tcp://45.33.57.181:5425", $errno, $errstr, STREAM_SERVER_BIND);
do {
	$pkt = stream_socket_recvfrom($socket_RX, $rxleng);
	// dump($pkt);
	// dump($socket_RX);

	socket_sendto($sock1, $pkt, $txleng, 0,  '127.0.0.1', 22099);
} while ($pkt !== false);
