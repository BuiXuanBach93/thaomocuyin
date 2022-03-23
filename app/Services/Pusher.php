<?php

namespace App\Services;

class Pusher
{
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $pusher;

    public function __construct()
    {
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );
        $this->pusher = new \Pusher\Pusher(
            '9fe65d6c94fa3e5401f9',
            '3327fb4838e449086f30',
            '844919',
            $options
        );
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function push($message, $channel='phukienone', $event='comment')
    {
        return $this->pusher->trigger($channel, $event, ['message'=>$message]);
    }

    public function pushNewCommentForUsers($users) {
        foreach($users as $userID => $number) {
            $this->push("Có $number comment mới", trimUserID($userID), 'comment');
        }
    }
}
