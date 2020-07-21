<?php











require "vendor/autoload.php";





$server = stream_socket_server("tcp://0.0.0.0:5425", $errno, $errstr);

$fp = stream_socket_client("tcp://data.aishub.net:5415", $errno, $errstr, 30);


if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    fwrite($fp, "Aloha");
    while (!feof($fp)) {
        file_put_contents("vesselfinder_ais_logs", fgets($fp, 1024), FILE_APPEND);
    }
    fclose($fp);
}

return;
