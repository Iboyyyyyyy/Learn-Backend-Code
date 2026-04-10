<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function createProduct($data){
        return Product::create($data);
    }
}
