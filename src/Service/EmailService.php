<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * EmailService constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param $from
     * @param $to
     * @param $subject
     * @param $template
     * @param $parameters
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function send($from, $to, $subject, $template, $parameters): void
    {
        $email = (new TemplatedEmail())
                ->from($from)
                ->to($to)
                ->subject($subject)
                ->htmlTemplate($template)
                ->context($parameters)
            ;
            
        // pour envoyer l'Email
        $this->mailer->send($email);
    }
}