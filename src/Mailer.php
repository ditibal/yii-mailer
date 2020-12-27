<?php

namespace ditibal\yiimailer;

use Yii;
use yii\swiftmailer\Mailer as BaseMailer;
use yii\di\Instance;
use yii\queue\Queue;


class Mailer extends BaseMailer
{
    public $messageClass = Message::class;
    public $queue;


    public function init()
    {
        parent::init();

        if ($this->queue) {
            $this->queue = Instance::ensure($this->queue, Queue::class);
        }
    }
}
