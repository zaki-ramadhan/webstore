<?php

namespace App\Livewire;

use App\Data\CartData;
use Livewire\Component;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Gate;
use App\Contract\CartServiceInterface;
use App\Data\RegionData;
use App\Services\RegionQueryService;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\DataCollection;

class Checkout extends Component
{

    // input fields
    public array $data = [
        "full_name" => null,
        "email" => null,
        "phone" => null,
        "address_line" => null,
        "destination_region_code" => null
    ];

    public array $region_selector = [
        'keyword' => null,
        'region_selected' => null
    ];

    public array $summaries = [
        "sub_total" => 0,
        "sub_total_formatted" => "-",
        "shipping_total" => 0,
        "shipping_total_formatted" => "-",
        "grand_total" => 0,
        "grand_total_formatted" => "-",
    ];

    public function mount()
    {
        // check if not allowed
        // to prevent access checkout page if the stock value less than quantity requested by user
        if (!Gate::inspect('is_stock_available')->allowed()) {
            return redirect()->route('cart');
        }

        $this->calculateTotal();
    }

    // add alias for better error message below its input
    protected $validationAttributes = [
        "data.full_name" => 'full name', // display "full name" instead of "data.full_name" as an error message below its input
        "data.email" => 'email address',
        "data.phone" => 'phone number',
        "data.shipping_line" => 'street address',
        'data.destination_region_code' => 'destination region',
    ];

    public function rules()
    {
        return [
            'data.full_name' => ['required', 'min:3', 'max:50'],
            'data.email' => ['required', 'min:3', 'max:50'],
            'data.phone' => ['required', 'min:3', 'max:13'],
            'data.shipping_line' => ['required', 'min:10', 'max:255'],
            'data.destination_region_code' => ['required'],
        ];
    }

    public function updatedRegionSelectorRegionSelected($value)
    {
        data_set($this->data, 'destination_region_code', $value);
    }

    public function placeAnOrder()
    {
        $this->validate();

        dd($this->data);
    }
    /**
     * Calculate cart totals using the data_set helper.
     *
     * ? The data_set(array, 'key', value) helper provides a safe way
     * to set a value within an array, even if the key doesn't exist yet.
     */

    public function calculateTotal()
    {
        data_set($this->summaries, 'sub_total', $this->cart->total);
        data_set($this->summaries, 'sub_total_formatted', $this->cart->total_formatted);

        $shipping_cost = 0;
        data_set($this->summaries, 'shipping_total', $shipping_cost);
        data_set($this->summaries, 'shipping_total_formatted', Number::currency($shipping_cost, 'IDR', 'id', 0));

        $grand_total = $this->cart->total + $shipping_cost;
        data_set($this->summaries, 'grand_total', $grand_total);
        data_set($this->summaries, 'grand_total_formatted', Number::currency($grand_total, 'IDR', 'id', 0));
    }

    public function getCartProperty(CartServiceInterface $cart): CartData
    {
        return $cart->all();
    }

    public function getRegionsProperty(RegionQueryService $query_service): DataCollection
    {
        // if input doesn't have any value
        if (!data_get($this->region_selector, 'keyword')) {
            $data = [];
            return new DataCollection(RegionData::class, []);
        }

        return $query_service->searchRegionByName(data_get($this->region_selector, 'keyword'));
    }

    public function getRegionProperty(RegionQueryService $query_service): ?RegionData
    {
        $region_selected = data_get($this->region_selector, 'region_selected');
        if (!$region_selected) {
            return null;
        }

        return $query_service->searchRegionByCode($region_selected);
    }


    public function render()
    {
        return view('livewire.checkout', [
            'cart' => $this->cart
        ]);
    }
}
