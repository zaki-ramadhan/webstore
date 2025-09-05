<main class="container mx-auto max-w-[85rem] w-full px-4 sm:px-6 lg:px-8 py-10 pb-28">
    <div class="grid grid-cols-1 gap-10 md:grid-cols-10">
        <div class="grid grid-cols-1 gap-10 pr-6 border-r border-gray-200 md:col-span-3">
            <div>
                <div class="space-y-3">
                    <input type="text" placeholder="Search" wire:model="search" wire:keydown.enter="applyFilters"
                        class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                </div>
                <span class="block mt-5 mb-2 text-lg font-semibold text-gray-800 dark:text-neutral-200">
                    Collections
                </span>
                <div class="block space-y-4">
                    @foreach ($collections as $i => $item)
                        <div class="flex items-center justify-between">
                            <div class="flex">
                                <input type="checkbox" wire:model="select_collections" value={{ $item->id }}
                                    class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                    id="hs-default-checkbox-{{ $i }}">
                                <label for="hs-default-checkbox-{{ $i }}"
                                    class="text-sm font-light ms-3 dark:text-neutral-400">
                                    {{ $item->name }}
                                </label>
                            </div>
                            <span class="text-xs text-gray-800 font-loght">({{ $item->product_count }})</span>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-2 gap-2 mt-10">
                    <button type="button" wire:click="applyFilters" wire:target="applyFilters"
                        wire:loading.attr="disabled" wire:loading.class="bg-blue-300"
                        class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg cursor-pointer gap-x-2 hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        <span wire:target="applyFilters" wire:loading class="flex justify-center items-center">
                            {{-- loading spinner by preline ui --}}
                            <span
                                class="animate-spin inline-block translate-y-0.5 mr-1 size-4 border-3 border-current border-t-transparent text-white rounded-full dark:text-white"
                                role="status" aria-label="loading">
                                <span class="sr-only">Loading...</span>
                            </span>
                            <span class="-translate-y-10">
                                Applying...
                            </span>
                        </span>

                        <span wire:target="applyFilters" wire:loading.remove>
                            Apply Filter
                        </span>
                    </button>
                    <button type="button" wire:click="resetFilters" wire:target="resetFilters"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center px-4 py-3 text-sm font-semibold text-blue-600 rounded-lg cursor-pointer gap-x-2 hover:bg-gray-100/70 hover:text-blue-800 active:bg-gray-200/50 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                        <span wire:target="resetFilters" wire:loading class="flex justify-center items-center">
                            {{-- loading spinner by preline ui --}}
                            <span
                                class="animate-spin inline-block translate-y-0.5 mr-1 size-4 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-600"
                                role="status" aria-label="loading">
                                <span class="sr-only">Loading...</span>
                            </span>
                            <span class="-translate-y-10">
                                Resetting...
                            </span>
                        </span>

                        <span wire:target="resetFilters" wire:loading.remove>
                            Reset
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-span-1 md:col-span-7">
            <div class="flex items-center justify-between gap-5">
                <div class="font-light text-gray-800">Results: {{ $products->total() }} Items</div>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-light text-gray-800 dark:text-neutral-200">
                        Sort By :
                    </span>
                    <select wire:model="sort_by" wire:change="applyFilters"
                        class="px-3 py-2 text-sm border-gray-200 rounded-lg pe-9 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        <option value="newest">Newest Products</option>
                        <option value="oldest">Oldest Products</option>
                        <option value="price_asc">Lowest Price</option>
                        <option value="price_desc">Highest Price</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 my-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
                @forelse($products as $product)
                    {{-- send product data through a props --}}
                    <x-single-product-card :product="$product" />
                @empty
                    <div
                        class="col-span-full w-full h-full aspect-5/2 grid place-content-center rounded-2xl bg-gray-100/80">
                        Product Not Found
                    </div>
                @endforelse
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</main>
