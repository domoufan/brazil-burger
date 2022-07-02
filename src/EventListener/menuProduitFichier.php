<?php
namespace App\EventListener;

use App\Entity\Menu;
use Doctrine\ORM\Event\LifecycleEventArgs;

class menuProduitFichier
{
    public function prePersist(Menu $menu,LifecycleEventArgs $even)
    {
        dd("HERE");
    }
}
