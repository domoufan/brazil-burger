<?php
namespace App\Services;

use App\Entity\User;
use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


class Mailer 
{
 public function __construct(MailerInterface $mailer,Environment $twig)
 {
    $this->mailer = $mailer ;
    $this->twig = $twig ;
 }
/**
 *  @param User $user
 */
    public function sendEmail($user)
    {
        $subject = 'Le Sujet' ;
        $email = (new Email())
            ->from('BrazilBurger@gmail.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text('Sending emails is fun again!')
            ->html(
                $this->twig->render('email/registration.html.twig',[
                    'user' => $user,
                    'subject' => $subject
                ]));
        

        $this->mailer->send($email);

    }
}