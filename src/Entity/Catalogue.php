<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    collectionOperations:
    [
            "catalogues"=>[
            "method"=>"get",
            "path"=>"/catalogues"
        ]
    ],
    itemOperations:
    [
        
    ]
)]
class Catalogue
{

}
