<?php
namespace App\Controller\DataPersister;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Livreur;
use App\Entity\Produit;
use App\Services\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Gestionnaire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        UserPasswordHasherInterface $encode,
        EntityManagerInterface $manager,
        Mailer $mailer,
        TokenStorageInterface $token
    ) {
        $this->encode = $encode;
        $this->manager = $manager;
        $this->mailer = $mailer;
        $this->token = $token->getToken();
    }

    public function supports($data, $context = []): bool
    {
        return $data instanceof User or
            $data instanceof Produit or
            $data instanceof Menu;
    }

    public function persist($data, $context = [])
    {
        $user = $this->token->getUser();

        if (!($data instanceof User)) {
            if ($user) {
                $data->setGestionnaire($user);
                $this->manager->persist($data);
                $this->manager->flush();
            } else {
                return new JsonResponse(['error' => 'invalid token']);
            }
        } elseif($data instanceof Livreur or $data instanceof Gestionnaire)
        {
            if ($user) {
                
                $data->setGestionnaire($user);
                $password = $this->encode->hashPassword(
                    $data,
                    $data->getPlainPassword()
                );
                $data->setPassword($password);
                $data->eraseCredentials();

                $this->manager->persist($data);
                $this->manager->flush();

                $this->mailer->sendEmail($data);
            } else {
                return new JsonResponse(['error' => 'invalid token']);
            }
        }
    }

    public function remove($data, $context = [])
    {
    }
}
