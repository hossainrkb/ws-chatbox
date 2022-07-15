<?php

namespace Rkb\SimpleChat;

use Exception;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

require __DIR__ . '/../vendor/autoload.php';
class ChatApp implements MessageComponentInterface
{
    protected $allClients;
    public function __construct()
    {
        $this->allClients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        echo "\nConn Established\n";
        $this->allClients->attach($conn);
    }
    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "\n$msg\n";
    }
    public function onClose(ConnectionInterface $conn)
    {
    }
    public function onError(ConnectionInterface $conn, Exception $e)
    {
    }
}
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatApp(),
        ),
    ),
    8006
);

$server->run();
