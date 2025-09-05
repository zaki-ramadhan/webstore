<?php

namespace App\Livewire;

use App\Data\ProductCollectionData;
use App\Data\ProductData;
use App\Models\Product;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{

    use WithPagination; // add this to use resetPage() and pagination()

    public array $select_collections = [];
    public string $search = '';
    public string $sort_by = 'newest'; // oldest, price_asc, price_desc,newest(default)


    // use this livewire helper to sync these values with the URL query string
    public $queryString = [
        'select_collections' => ['except' => []], // exclude if empty
        'search' => ['except' => []],
        'sort_by' => ['except' => 'newest']       // 'newest' is default, so skip in URL
    ];


    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->select_collections = [];
        $this->search = '';
        $this->sort_by = 'newest';
        $this->resetPage();
    }

    public function render()
    {
        $collection_result = Tag::query()->withType('collection')->withCount('products')->get();
        $query = Product::query();

        // search
        if ($this->search) $query->where('name', 'LIKE',  "%{$this->search}%");

        // select collections
        if (!empty($this->select_collections)) {
            // query
            $query->whereHas('tags', function ($query) {
                // sub query
                $query->whereIn('id', $this->select_collections);
            });
        }

        // sort by
        switch ($this->sort_by) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                // sort by 'newest'
                $query->latest();
                break;
        }

        $products = ProductData::collect($query->paginate(9));
        $collections = ProductCollectionData::collect($collection_result);

        return view('livewire.product-catalog', compact('products', 'collections'));
    }
}
