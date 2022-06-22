<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Services\Mailer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $encode ,Mailer  $mailer)
    {
        $this->encode = $encode;
        $this->mailer = $mailer;
    }
    public function load(ObjectManager $manager ): void
    {
        $client = new Client();
        $client->setEmail('unclient@gmail.com');
        $password = $this->encode->hashPassword($client,'unclient');
        $client->setPassword($password);
        $client->setRoles(['ROLE_CLIENT']);
        $client->setPrenom('un');
        $client->setNom('client');
        $client->setAdresse('chezunclient');
        $client->setTel('numunclient');
        $client->setEtat(0);

        $manager->persist($client);
        $manager->flush();
        $this->mailer->sendEmail($client);
    }
}
