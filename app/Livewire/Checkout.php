<?php

namespace App\Livewire;

use App\Data\CartData;
use Livewire\Component;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Gate;
use App\Contract\CartServiceInterface;
use App\Data\RegionData;
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

    public function updatedRegionSelectorRegionSelected($value) {
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

    public function getRegionsProperty(): DataCollection
    {
        // reference to region data
        $data = [
            [
                'code' => '001',
                'province' => 'Jawa Barat',
                'city' => 'Kota Cirebon',
                'district' => 'Kejaksan',
                'sub_district' => 'Kejaksan',
                'postal_code' => '45121',
            ],
            [
                'code' => '002',
                'province' => 'Jawa Barat',
                'city' => 'Kota Cirebon',
                'district' => 'Lemahwungkuk',
                'sub_district' => 'Panjunan',
                'postal_code' => '45111',
            ],
            [
                'code' => '003',
                'province' => 'Jawa Barat',
                'city' => 'Kota Cirebon',
                'district' => 'Harjamukti',
                'sub_district' => 'Kalijaga',
                'postal_code' => '45144',
            ],
            [
                'code' => '004',
                'province' => 'Jawa Barat',
                'city' => 'Kota Cirebon',
                'district' => 'Pekalipan',
                'sub_district' => 'Pekalangan',
                'postal_code' => '45117',
            ],
            [
                'code' => '005',
                'province' => 'Jawa Barat',
                'city' => 'Kota Cirebon',
                'district' => 'Kesambi',
                'sub_district' => 'Drajat',
                'postal_code' => '45133',
            ],
        ];

        // if input doesn't have any value
        if (!data_get($this->region_selector, 'keyword')) {
            $data = [];
        }

        return new DataCollection(RegionData::class, $data);
    }

    public function getRegionProperty(): ?RegionData
    {
        $region_selected = data_get($this->region_selector, 'region_selected');
        if (!$region_selected) {
            return null;
        }

        return $this->regions->toCollection()->first(fn(RegionData $region) => $region->code == $region_selected);
    }


    public function render()
    {
        return view('livewire.checkout', [
            'cart' => $this->cart
        ]);
    }
}
