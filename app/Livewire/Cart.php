<?php

namespace App\Livewire;

use App\Actions\ValidateCartStock;
use Livewire\Component;
use App\Contract\CartServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class Cart extends Component
{
    public string $sub_total;
    public string $total;

    public function mount(CartServiceInterface $cart)
    {
        $all = $cart->all();

        $this->sub_total = $all->total_formatted;
        $this->total = $this->sub_total;
    }

    public function getItemsProperty(CartServiceInterface $cart): Collection
    {
        return $cart->all()->items->toCollection();
    }

    public function checkout()
    {
        try {
            ValidateCartStock::run();
            
            return redirect()->route('checkout');
        } catch (ValidationException $error) {
            session()->flash('error', $error->getMessage());

            return redirect()->route('cart');
        }
    }

    public function render()
    {
        return view('livewire.cart', ['items' => $this->items]);
    }
}
