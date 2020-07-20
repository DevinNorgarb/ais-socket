<?php

require "vendor/autoload.php";

$servername="localhost";
$servername="127.0.0.1";
$username="root";
$password="S0m3thingS3cr3t";
$database="marine_tracker";

try {
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected successfully";
  } catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
  }

//Reduce errors
error_reporting(~E_WARNING);

//Create a UDP socket
if(!($sock = socket_create(AF_INET, SOCK_DGRAM, 0)))
{
	$errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Couldn't create socket: [$errorcode] $errormsg \n");
}

echo "Socket created \n";

// Bind the source address
if( !socket_bind($sock, "0.0.0.0" , 9998) )
{
	$errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Could not bind socket : [$errorcode] $errormsg \n");
}

echo "Socket bind OK \n:";

//Do some communication, this loop can handle multiple clients
while(1)
{
	echo"Waiting for data ... \n";

	//Receive some data
	$r = socket_recvfrom($sock, $buf, 512, 0, $remote_ip, $remote_port);

	echo "$remote_ip : $remote_port -- " . $buf;

	$parts = explode('\!A', $buf);
	// $meta = explode("c:", $parts[0]);
	// $meyta2 = explode("c:", $meta[1]);
	// $dATE = ""
	// if (isset($meyta2[1])) {
	// 	$dATE = explode(",", $meyta2[1]);
	// 	dump($dATE);
	// }

	// if (isset($dATE[1])) {
	// 	# code...
	// 	dump($dATE[1]);
	// }
	// continue;
	// $timestamp = str_replace("\c:", "", $meta[0]);
	// // dump($parts[0], $meta);
	// // $timestamp = $meta[0];

	// $dt = new DateTime("@$timestamp");  // convert UNIX timestamp to PHP DateTime
	// $date = $dt->format('Y-m-d H:i:s'); // output = 2017-01-01 00:00:00

	// if (!is_null($date)) {
	// 	# code...
	// }
	// dump($date);
	$parts[1] = "!A".$parts[1];


	$part = $parts[1];
	$part = str_replace("\r\n","",$parts[1]);

	$date = date('Y-m-d H:i:s');

	file_put_contents("./ais.log", $date . " | ".  $parts[1],  FILE_APPEND);



$part = "'".$part."'";
$date = "'".$date."'";
$remote_ip = "'".$remote_ip."'";

	try {
		$sql = "INSERT INTO ais_logs (ais_code, created_at, ip_address) VALUES ($part, $date, $remote_ip)";
		// use exec() because no results are returned
		// dump($conn);
		// if (condition) {
		// 	# code...
		// }
		$conn->exec($sql);
		echo "New record created successfully";
	  } catch(PDOException $e) {
		dump( $sql);

		dump( $e->getMessage());

	  }



	file_put_contents("./ais.log", $date . " | ".  $parts[1],  FILE_APPEND);


	//Send back the data to the client
	// socket_sendto($sock, "OK. ". $buf , 100 , 0 , $remote_ip , $remote_port);
}

socket_close($sock);
