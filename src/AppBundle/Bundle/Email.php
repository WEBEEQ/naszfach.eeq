<?php
// src/AppBundle/Bundle/Email.php
namespace AppBundle\Bundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Email
{
    protected $controller = null;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function sendEmail($emailFrom, $emailTo, $subject, $text)
    {
        $message = \Swift_Message::newInstance()
            ->setFrom($emailFrom)
            ->setTo($emailTo)
            ->setSubject($subject)
            ->setBody(
                $this->controller->renderView('email/email.html.twig', array(
                    'emailFrom' => $emailFrom,
                    'emailTo' => $emailTo,
                    'subject' => $subject,
                    'text' => $text
                )),
                'text/html'
            )
        ;

        return $this->controller->get('mailer')->send($message);
    }
}
