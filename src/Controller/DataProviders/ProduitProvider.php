<?php
namespace App\Controller\DataProviders;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class ProduitProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(ProduitRepository $produit)
    {
        $this->produit = $produit ;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return   $resourceClass === Produit::class;
    }
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []){

        return $this->produit->findByLike("");
    }
    
}
