<?php

namespace ditibal\yiimailer;

use ditibal\yiimailer\queue\SendEmailJob;
use Yii;
use yii\mail\MailerInterface;
use yii\swiftmailer\Message as BaseMessage;


class Message extends BaseMessage
{
    private $_async;
    private $pushDelay;


    public function async()
    {
        $this->_async = true;
        return $this;
    }

    public function delay($value)
    {
        $this->pushDelay = $value;
        return $this;
    }

    public function send(MailerInterface $mailer = null)
    {
        if ($this->mailer->queue && !$this->_async) {
            $this->mailer
                ->queue
                ->delay($this->pushDelay)
                ->push(new SendEmailJob([
                    'mail' => $this,
                ]));

            return true;
        }

        return parent::send($mailer);
    }
}
