<?php
namespace App\Controller\DataPersister;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Zone;
use App\Entity\Client;
use App\Entity\Livreur;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Services\Mailer;
use App\Entity\Gestionnaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Elastica\Request;
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
            $data instanceof Menu or
            $data instanceof Commande or
            $data instanceof Zone;
    }

    public function persist($data, $context = [])
    {
        $user = null;
        if ($this->token) {
           $user = $this->token->getUser();
        }

        if (!($data instanceof User)) {
            if ($user) {
                if ($data instanceof Commande) {
                    $data->setClient($user);
                }                
                if ($data instanceof Menu or $data instanceof Produit or $data instanceof Zone or $data instanceof User) {
                    $data->setGestionnaire($user);
                    if ($data->getImageName()) {
                        $data->setImageFile(file_get_contents($data->getImageName()));
                    }
                }
                $this->manager->persist($data);
                $this->manager->flush();
            } else {
                return new JsonResponse(['error' => 'invalid token']);
            }
        } elseif($data instanceof Livreur or $data instanceof Gestionnaire or $data instanceof Client)
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
            } elseif ($data instanceof Gestionnaire or $data instanceof Client) {
                                $password = $this->encode->hashPassword(
                    $data,
                    $data->getPlainPassword()
                );
                $data->setPassword($password);
                $data->eraseCredentials();

                $this->manager->persist($data);
                $this->manager->flush();

                $this->mailer->sendEmail($data);
            }else{
                return new JsonResponse(['error' => 'invalid token']);
            }
        }
    }

    public function remove($data, $context = [])
    {
    }
}
