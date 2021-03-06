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
        // $numRecv = count($this->clients) - 1;
        // echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
        // , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $data = json_decode($msg, true);
        $tempArray = [];
        foreach ($this->allClients as $client) {
            if ($client == $from) {
                $tempArray = [
                    'from' => 'Me',
                    'from_id' => $from->resourceId,
                    'client_id' => '',
                    'message' => $data['message']
                ];
            }else{
                $tempArray = [
                    'from' => $data['from_user'],
                    'from_id' => $from->resourceId,
                    'client_id' => '',
                    'message' => $data['message']
                ];
            }
            $client->send(json_encode($tempArray));
        }
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
