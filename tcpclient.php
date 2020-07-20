<?php
require "vendor/autoload.php";

$fp = stream_socket_client("tcp://data.aishub.net:5415", $errno, $errstr);

feof($fp);
dump(feof($fp));
$i = 0;
while (!feof($fp) != false) {
    $i++;
    echo fread($fp, 1024 * 8);
    dump($i);


    // if (!$fp) {
    //     echo "ERROR: $errno - $errstr<br />\n";
    // } else {
    //     fwrite($fp, "\n");
    //     echo fread($fp, 26);
    //     fclose($fp);
    // }
}
