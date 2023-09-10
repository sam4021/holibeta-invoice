<?php

namespace App\Interfaces;

interface ProductInterface
{

    public function getProducts();
    public function productById(string $id);
    public function productBySlug(string $slug);
    public  function createProduct(array $attributes);
    public function updateProduct(array $data, string $id);

}
