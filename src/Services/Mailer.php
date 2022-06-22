<?php
namespace App\Services;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


class Mailer 
{
 public function __construct(MailerInterface $mailer)
 {
    $this->mailer = $mailer ;
 }
/**
 *  @param User $user
 */
    public function sendEmail($user)
    {
        $email = (new Email())
            ->from('BrazilBurger@gmail.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Le Sujet')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);

    }
}