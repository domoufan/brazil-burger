<?php
namespace App\Controller;

use App\Entity\Menu;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController {

    public function __invoke(Request $request,ProduitRepository $prodRepo,EntityManagerInterface $entityManager)
    {
        if ($request->isMethod('POST')) {
            $data = json_decode($request->getContent());
            
            $menu = new Menu();

            $menu->setNom($data->nom);
            $menu->setType($data->type);
        
            foreach ($data->menuProduits as $prod) {
                $produit=$prodRepo->find($prod->produit);
                if ($produit) {
                    $menu->addProduit($produit,$prod->quantity);
                }
            }
            $entityManager->persist($menu);
            $entityManager->flush();
        }        
    }
}


