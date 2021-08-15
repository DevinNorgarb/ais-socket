<?php

require 'vendor/autoload.php';

use React\Socket\ConnectionInterface;


$loop = React\EventLoop\Factory::create();
$loop2 = React\EventLoop\Factory::create();
$connector = new React\Socket\Connector($loop);


$server = new React\Socket\TcpServer('tcp://45.33.57.181:5425', $loop);

$server->on('connection', function (ConnectionInterface $client) use ($server, $connector, $loop, $loop2) {
    // whenever a new message comes in

    $connector->connect('data.aishub.net:5415')->then(function (React\Socket\ConnectionInterface $connection) use ($loop2, $loop, $server, $client) {


        // dump($client->getRemoteAddress());
        // $conn = stream_socket_client($client->getRemoteAddress());
        dump("---------------------------------------------------------------------------------");
        dump($server);
        dump("-------- -------------------------------------------------------------------------");
        // $server->
        // dd($connection);
        // $stream = new \React\Stream\DuplexResourceStream($conn, $loop);
        $connection->pipe(new React\Stream\WritableResourceStream(STDOUT, $loop));
        $client->pipe(new React\Stream\WritableResourceStream(STDOUT, $loop));
        // ->pipe(new React\Stream\WritableResourceStream(STDIN, $loop2));

        // $stream->write('hello!');
        // $stream->end();
        $client->on('data', function ($data) use ($client, $server) {
            dump($data);
        });

        // dump($server->getConnections());
        // $connection->write("dscsdcscd");
        foreach ($server->getConnections() as $connection) {
            dump($connection);
        }


        // $server->getConnection();
        // ("Hello World!\n");
    });




    // dump($client);
    // $client->on('data', function ($data) use ($client, $server) {
    //     dump($client);
    //     // remove any non-word characters (just for the demo)
    //     $data = trim(preg_replace('/[^\w\d \.\,\-\!\?]/u', '', $data));

    //     // ignore empty messages
    //     if ($data === '') {
    //         return;
    //     }

    //     // prefix with client IP and broadcast to all connected clients
    //     $data = trim(parse_url($client->getRemoteAddress(), PHP_URL_HOST), '[]') . ': ' . $data . PHP_EOL;
    // });
});
$loop->run();
$loop2->run();
// die;


// $connector->connect('data.aishub.net:5415')->then(function (React\Socket\ConnectionInterface $connection) use ($loop, $server) {
//     // dump($loop);


//     // $server->on('connection', function (React\Socket\ConnectionInterface $con) use ($connection, $loop) {
//     //     echo 'Plaintext connection from ' . $con->getRemoteAddress() . PHP_EOL;
//     //     $connection->pipe(new React\Stream\WritableResourceStream(STDOUT, $loop));
//     //     $con->write('hello there!' . PHP_EOL . ' Plaintext connection from ' . $con->getRemoteAddress() . PHP_EOL);
//     // });

//     $connection->pipe(new React\Stream\WritableResourceStream(STDOUT, $loop));
//     // $server->getConnection();
//     // ("Hello World!\n");
// });

// $loop->run();


// $socket->on('data', function (React\Socket\ConnectionInterface $connection) {
//     $connection->write("Hello " . $connection->getRemoteAddress() . "!\n");
//     $connection->write("Welcome to this amazing server!\n");
//     $connection->write("Here's a tip: don't say anything.\n");

//     $connection->on('data', function ($data) use ($connection) {
//         dump($data);
//         // $connection->close();
//     });
// });

// $loop->run();
