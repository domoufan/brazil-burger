<?php
namespace App\Security;

use App\Entity\Gestionnaire;
use App\Entity\Produit;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\CacheableVoterInterface;

class ProduitVoter extends Voter implements CacheableVoterInterface
{
    const AJOUTER = 'ajouter';
    const LISTER = 'lister';
    const SUPPRIMER = 'supprimer';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (
            !in_array($attribute, [
                self::AJOUTER,
                self::LISTER,
                self::SUPPRIMER,
            ])
        ) {
            return false;
        }

        if (!($subject instanceof Produit)) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(
        string $attribute,
        mixed $subject,
        TokenInterface $token
    ): bool {
        $user = $token->getUser();

        if (!($user instanceof Gestionnaire)) {
            return false;
        }

        $produit = $subject;

        switch ($attribute) {
            case self::AJOUTER:
                return $this->peutAjouter($produit, $user);

                break;
            case self::LISTER:
                return $this->peutLister($produit, $user);

                break;
            case self::SUPPRIMER:
                return $this->peutSupprimer($produit, $user);

                break;
        }
    }
    public function peutAjouter($produit, $user)
    {
        return true;
    }
    public function peutLister($produit, $user)
    {
        if ($this->peutLister($produit, $user)) {
            return true;
        }
    }
    public function peutSupprimer($produit, $user)
    {
        return true;
    }
}
