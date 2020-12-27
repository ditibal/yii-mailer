<?php

namespace ditibal\yiimailer\debug;

use Yii;
use ditibal\yiimailer\Mailer as BaseMailer;


class Mailer extends BaseMailer
{
    public $message;
    public $messageClass = Message::class;


    protected function createMessage()
    {
        $config = $this->messageConfig;
        if (!array_key_exists('class', $config)) {
            $config['class'] = $this->messageClass;
        }

        $config['mailer'] = $this;
        $config['message'] = $this->message;
        return Yii::createObject($config);
    }
}
