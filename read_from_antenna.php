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



// Opening a file
$myfile = fopen("/dev/serial0", "r");
$sock1 = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
$txleng = 1024;
$rxleng = 160;
// loop around the file to output the content
// line by line
while(true) {
    if (!feof($myfile)) {
        # code...
        echo fgets($myfile);
        socket_sendto($sock1, fgets($myfile), $txleng, 0,  '5.9.207.224', 11144);
        socket_sendto($sock1, fgets($myfile), $txleng, 0,  '144.76.105.244', 3415);
        file_put_contents('log.txt', fgets($myfile).PHP_EOL, FILE_APPEND);
    }
}
fclose($myfile);

// closing the file
