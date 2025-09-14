<?php

declare(strict_types=1);

namespace App\Contract;

use App\Data\CartData;
use App\Data\CartItemData;

interface CartServiceInterface {
    // abstract methods
    public function addOrUpdate(CartItemData $item);
    public function remove(string $sku);
    public function getItemBySku(string $sku) : ?CartItemData;
    public function all() : CartData;
}