<?php
namespace App\Controller\DataProviders;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\ProduitRepository;

class CatalogueProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface
{
    public function __construct(MenuRepository $menu,ProduitRepository $produit)
    {
        $this->menu = $menu;
        $this->produit = $produit;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Catalogue::class ;
    }

    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = [])
    {
        $tab['menu'] = $this->menu->findAll();
        $tab['produit'] = $this->produit->findByNoLikeType('COMPLEMENT');

        return $tab ;
    }
}