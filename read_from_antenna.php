<?php

// require("phpSerial.php"); //  /dev/ttyAMA0 ttyS0
//     $serial = new phpSerial();
//     $serial->deviceSet("/dev/ttyS0"); //SET THIS TO WHATEVER YOUR SERIAL DEVICE HAPPENS TO BE, YOU CAN FIND THIS UNDER THE ARDUINO SOFTWARE'S MENU
//     $serial->confBaudRate(9600); //Baud rate: 19200 or 115200
//     $serial->deviceOpen();
// 	// And to read from
// 	$read = $serial->readPort(30);
// 	var_dump ($read);

//     var_dump($serial);



//try this
// fwrite($stream, "enable");
while(true){
    $stream = fopen("/dev/serial0", "rw+");

    // $line = fread( $stream, 70);
    // echo $line;
    $line = fgets($stream);
    if($line != ''){
    var_dump($line);
    sendTo($line);

    // fclose($stream);

    // break;
}
}
return;



// Opening a file
$myfile = fopen("/dev/serial0", "rw+");
$sock1 = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
$txleng = 1024;
$rxleng = 160;
// loop around the file to output the content
// line by line


// while(true) {
//  if (!feof($myfile)) {
//         # code...
//         echo fgets($myfile,26);

//         sendTo(fgets($myfile));

//         file_put_contents('log.txt', fgets($myfile).PHP_EOL, FILE_APPEND);
//      }
// }
//fclose($myfile);

function sendTo($msg) {
    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

    $len = strlen($msg);

    socket_sendto($sock, $msg, $len, 0,     '5.9.207.224', 11144);
    socket_sendto($sock, $msg, $len, 0, '144.76.105.244', 3415);


    socket_close($sock);
}

// closing the file
