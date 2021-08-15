<?php

while(true){
    $stream = fopen("/dev/serial0", "rw+");

    // $line = fread( $stream, 70);
    // echo $line;
    $line = fgets($stream);
    if(!empty($line)){
    // var_dump($line);
    sendTo($line);
}
}

function sendTo($msg) {
    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

    $len = strlen($msg);

    echo($msg);
    socket_sendto($sock, $msg, $len, 0,     '5.9.207.224', 11144);
    socket_sendto($sock, $msg, $len, 0, '144.76.105.244', 3415);
    socket_sendto($sock, $msg, $len, 0, '0.0.0.0', 1234);

    if(!file_exists("/home/pi/ais-socket/".date('Y-m-d').'.txt')) {
 	file_put_contents("/home/pi/ais-socket/".date('Y-m-d').'.txt', "");
	chmod("/home/pi/ais-socket/".date('Y-m-d').'.txt', 0755);
    }

    file_put_contents("/home/pi/ais-socket/".date('Y-m-d').'.txt', $msg.PHP_EOL, FILE_APPEND);

    socket_close($sock);
}
