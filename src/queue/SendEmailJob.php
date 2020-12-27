<?php

namespace ditibal\yiimailer\queue;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class SendEmailJob extends BaseObject implements JobInterface
{
    public $mail;


    public function execute($queue)
    {
        $mail = $this->mail;

        $mailer = $this->mail->mailer;
        $mail->async();

        return $mailer->send($mail);
    }
}
