<?php
namespace App\Controller;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailValidatorController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Request $requrest, UserRepository $use)
    {
        $token = $requrest->get('token');
        $user = $use->findOneBy(['token' => $token]);
        
        if (!$user) {
            return new JsonResponse(
                ['error' => 'Token Invalide'],
                Response::HTTP_BAD_REQUEST
            );
        }
        if ($user->isIsEnable()) {
                return new JsonResponse(
                    ['error' => 'Utilisateur deja actif'],
                    Response::HTTP_BAD_REQUEST
                );
        }
        if ($user->getExpiredAt() < new \DateTime()) {
                return new JsonResponse(
                    ['error' => 'Token expirer'],
                    Response::HTTP_BAD_REQUEST
                );
        }
            $user->setIsEnable(true);
            $this->manager->flush();
                    return new JsonResponse(
                    ['success' => 'Bravo , Compte activé avec succes'],
                    Response::HTTP_OK
                );
    }
}
