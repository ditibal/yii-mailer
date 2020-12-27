<?php

namespace ditibal\yiimailer\debug;

use common\queue\jobs\SendEmailJob;
use Yii;
use yii\mail\MailerInterface;
use yii\helpers\ArrayHelper;
use ditibal\yiimailer\Message as BaseMessage;


class Message extends BaseMessage
{
    public $message;
    protected $oldTo;
    protected $oldFrom;


    public function send(MailerInterface $mailer = null)
    {
        $this->oldTo = $this->to;
        $this->oldFrom = $this->from;

        $this->to = $this->message['to'];
        $this->from = $this->message['from'];

        $this->setSubject($this->getSubject() . ' -- ' . time());
        $this->attachContent($this->debugInfo, ['contentType' => 'text/html']);

        return parent::send($mailer);
    }

    protected function addressesToString($addresses)
    {
        if (is_string($addresses)) {
            return $addresses;
        }

        if (ArrayHelper::isAssociative($addresses)) {
            $addresses = array_map(function ($name, $email) {
                if (empty($name)) {
                    return $email;
                }

                return $name . " <{$email}>";
            }, $addresses, array_keys($addresses));
        }

        return implode(', ', $addresses);
    }

    protected function getDebugInfo()
    {
        $to = $this->addressesToString($this->oldTo);
        $from = $this->addressesToString($this->oldFrom);

        $to = htmlentities($to);
        $from = htmlentities($from);

        $html = '<br><br><br>Debug info:<hr><br>';
        $html .= "To: {$to}<br>";
        $html .= "From: {$from}<br>";

        return $html;
    }
}
