<?php

namespace App\Services;

class CartService
{
    public static function getItemsInCart($products)
    {
        $items = [];

        foreach ($products as $product) {
            $items[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'ownerName' => $product->shop->owner->name,
                'ownerEmail' => $product->shop->owner->email,
            ];
        }
        return $items;
    }
}
