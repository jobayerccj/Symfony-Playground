<?php
namespace App\Service;
use Nexy\Slack\Client;

class SlackClient{

    private $slack;
    
    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }
    public function sendMessage($from, $message){
        $slackMessage = $this->slack->createMessage()
                    ->to('#gpl-motion')
                    ->from($from)
                    ->withIcon(':ghost:')
                    ->setText($message)
        ;

        $this->slack->sendMessage($slackMessage);
    }
}