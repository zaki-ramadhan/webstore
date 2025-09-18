<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Product;
use Livewire\Component;
use App\Data\ProductData;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Data\ProductCollectionData;

class ProductCatalog extends Component
{

    use WithPagination; // add this to use resetPage() and pagination()

    #[Url(as: 'collections', except: [])]
    public array $select_collections = [];

    #[Url(as: 's')]
    public string $search = '';

    #[Url(except: 'newest')] 
    public string $sort_by = 'newest'; // oldest, price_asc, price_desc,newest(default)

    // validation rules
    protected function rules() {
        return [
            'select_collections'    => 'array',
            'select_collections.*'  => 'integer|exists:tags,id',
            'search'                => 'nullable|string|min:3|max:30',
            'sort_by'               => 'in:newest,oldest,price_asc,price_desc'
        ];
    }

    // use Livewire helper / function. Validate on every mount to prevent bypassing validation via URL
    public function mount() {
        $this->validate();
    }

    // use this livewire helper to sync these values with the URL query string
    // public $queryString = [
    //     'select_collections' => ['except' => []], // exclude if empty
    //     'search' => ['except' => ''],
    //     'sort_by' => ['except' => 'newest']       // 'newest' is default, so skip in URL
    // ];


    public function applyFilters()
    {
        $this->validate();
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'select_collections',
            'search',
            'sort_by'
        ]);

        $this->resetPage();
        $this->resetValidation();
    }

    public function render()
    {
        // set empty for product and collections
        $products = ProductData::collect([]);
        $collections = ProductCollectionData::collect([]);
        
        // if get any error, then display new blank page
        if($this->getErrorBag()->isNotEmpty()) return view('livewire.product-catalog', compact('products', 'collections'));

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

        // this will override the previous empty variable
        $products = ProductData::collect($query->paginate(9));
        $collections = ProductCollectionData::collect($collection_result);

        return view('livewire.product-catalog', compact('products', 'collections'));
    }
}
