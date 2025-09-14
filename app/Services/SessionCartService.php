<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\CartData;
use App\Data\CartItemData;
use Illuminate\Support\Collection;
use App\Contract\CartServiceInterface;
use Spatie\LaravelData\DataCollection;
use Illuminate\Support\Facades\Session;

class SessionCartService implements CartServiceInterface {

    protected string $session_key = 'cart';
    
    // function for load data
    protected function load() : DataCollection{

        // get session
        $raw = Session::get($this->session_key, []);
        return new DataCollection(CartItemData::class, $raw);
    }

    /** @param Collection <int,CartItemData> $items */ // ts for documentation purpose only
    protected function save(Collection $items)
    {
        Session::put($this->session_key, $items->values()->all());
    }
    
    // cart interface abstract methods`
    public function addOrUpdate(CartItemData $item)
    {
        // 1. Fetch data
        $collection = $this->load()->toCollection();
        $updated = false;

        // 2. Mapping, if exist then do update, if doesn't exist then do add
        $cart = $collection->map(function(CartItemData $i) use ($item, &$updated){

            // if new data exist, then do update
            if($i->sku == $item->sku) {
                $updated = true;
                return $item;
            }

            // if new data doesn't exist, return old data
            return $i;
        })->values()->collect();

        // push un-updated data
        if (! $updated) $cart->push($item);

        // 3. Save
        $this->save($cart);
    }

    
    public function remove(string $sku)
    {
        $cart = $this->load()->toCollection()
            ->reject(fn(CartItemData $item) => $item->sku === $sku)
            ->collect();

        $this->save($cart);
    }
    public function getItemBySku(string $sku): ?CartItemData
    {
        return $this->load()->toCollection()->first(fn(CartItemData $item) => $item->sku === $sku);
    }
    public function all() :CartData
    {
        return new CartData($this->load());
    }
}