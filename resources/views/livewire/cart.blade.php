<div class="container mx-auto max-w-[85rem] w-full px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid gap-10 md:grid-cols-10">
        <div class="md:col-span-7">
            <h1 class="mb-10 text-2xl font-light">Shopping Bag</h1>
            <div class="grid gap-5">
                @forelse ($items as $item)
                    <div class="flex gap-5 border-b border-gray-200">
                        <div class="relative size-40 overflow-hidden rounded-xl">
                            <img class="object-coversize-full" src="{{ $item->product()->cover_url }}"
                                alt="Product {{ $item->sku }}">
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                                {{ $item->product()->name }}
                            </h2>
                            <h4 class="text-sm text-gray-800">{{ $item->product()->short_desc }}</h4>

                            <div class="flex items-center gap-3 my-5">
                                <livewire:add-to-cart wire:key="add-to-cart-{{ $item->sku }}" :product="$item->product()" />

                                <div class="py-5 flex items-start self-stretch">
                                    <p class="inline py-1.5 px-3 text-xl font-semibold text-black dark:text-black">
                                        {{ $item->calculatedTotalFormatted() }}
                                    </p>
                                    <livewire:cart-item-remove :product="$item->product()" />
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="w-full h-auto aspect-video md:aspect-5/2 -mt-3 border-[1.35px] border-red-300 rounded-2xl flex items-center justify-center text-red-500 font-medium bg-red-50/70">
                        No Product</div>
                @endforelse
            </div>
        </div>

        {{-- order summary --}}
        <div class="md:col-span-3">
            <h1 class="mb-5 text-2xl font-light">Order Summary</h1>
            <div class="grid gap-5">
                <!-- List Group -->
                <ul class="flex flex-col mt-3">
                    <li
                        class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                        <div class="flex items-center justify-between w-full">
                            <span>Sub Total</span>
                            <span>{{ $sub_total }}</span>
                        </div>
                    </li>
                    <li
                        class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                        <div class="flex items-center justify-between w-full">
                            <span>Shipping</span>
                            <span>—</span>
                        </div>
                    </li>
                    <li
                        class="inline-flex items-center px-4 py-3 -mt-px text-sm font-semibold text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200">
                        <div class="flex items-center justify-between w-full">
                            <span>Total</span>
                            <span>{{ $total }}</span>
                        </div>
                    </li>
                </ul>
                <!-- End List Group -->
                <button type="button" wire:click="checkout" wire:target="checkout" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg cursor-pointer gap-x-2 hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:cursor-default">
                    <span wire:target="checkout" wire:loading class="flex justify-center items-center">
                        {{-- loading spinner by preline ui --}}
                        <span
                            class="animate-spin inline-block translate-y-0.5 mr-1 size-4 border-3 border-current border-t-transparent text-white rounded-full dark:text-white"
                            role="status" aria-label="loading">
                        </span>
                        <span class="-translate-y-10">
                            Checking Out...
                        </span>
                    </span>

                    <span wire:target="checkout" wire:loading.remove>
                        Checkout Now
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
