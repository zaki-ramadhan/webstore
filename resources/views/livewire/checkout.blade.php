<div class="container mx-auto max-w-[85rem] w-full px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid gap-5 md:gap-20 md:grid-cols-2">
        <div class="p-10">
            <!-- Section -->
            <div
                class="py-6 border-t border-gray-200 first:pt-0 last:pb-0 first:border-transparent dark:border-neutral-700 dark:first:border-transparent">
                <label for="af-payment-billing-contact" class="inline-block text-sm font-medium dark:text-white">
                    Billing contact
                </label>

                <div class="grid grid-cols-2 gap-3 mt-2">
                    <div class="col-span-2">
                        <input id="af-payment-billing-contact" type="text" wire:model="data.full_name"
                            class="@error('data.full_name') border-red-600 @enderror py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs sm:text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-default dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Full Name">
                        @error('data.full_name')
                            <p class="mt-2 text-xs text-red-600" id="hs-validation-name-error-helper">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <input type="text" wire:model="data.email"
                            class="@error('data.email') border-red-600 @enderror py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs sm:text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-default dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Email">
                        @error('data.email')
                            <p class="mt-2 text-xs text-red-600" id="hs-validation-name-error-helper">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <input type="number" wire:model="data.phone"
                            class="@error('data.phone') border-red-600 @enderror py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs sm:text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-default dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Phone Number">
                        @error('data.phone')
                            <p class="mt-2 text-xs text-red-600" id="hs-validation-name-error-helper">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section -->
            <div
                class="py-6 mt-5 border-t border-gray-200 first:pt-0 last:pb-0 first:border-transparent dark:border-neutral-700 dark:first:border-transparent">
                <label for="af-payment-billing-address" class="inline-block text-sm font-medium dark:text-white">
                    Billing address
                </label>

                <div class="mt-2 space-y-3">
                    <input id="af-payment-billing-address" type="text" wire:model="data.shipping_line"
                        class="@error('data.shipping_line') border-red-600 @enderror py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs sm:text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-default dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Street Address">
                    @error('data.shipping_line')
                        <p class="mt-2 text-xs text-red-600" id="hs-validation-name-error-helper">
                            {{ $message }}
                        </p>
                    @enderror
                    <div>
                        <div x-data="{ open: false }" class="relative w-full">
                            <input type="text" wire:model.live.debounce.500ms="region_selector.keyword"
                                @focus="open = true" @click.outside="open = false"
                                class="@error('data.destination_region_code') border-red-600 @enderror sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs sm:text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-default dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Find location">

                            @if ($this->regions->toCollection()->isNotEmpty())
                                <ul class="absolute z-10 w-full mt-2 overflow-y-auto bg-white border border-gray-200 rounded-lg max-h-60 shadow-xl"
                                    x-show="open">
                                    @foreach ($this->regions as $region)
                                        <li class="text-sm p-3 cursor-pointer hover:bg-gray-100">
                                            <label for="region-{{ $region->code }}"
                                                class="w-full inline-block cursor-pointer">
                                                <input id="region-{{ $region->code }}" type="radio"
                                                    value="{{ $region->code }}"
                                                    wire:model.live="region_selector.region_selected" class="sr-only" />
                                                {{ $region->label }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($this->region)
                                <p class="mt-2 text-sm text-gray-600">
                                    Lokasi Dipilih
                                    <strong>{{ $this->region->label }}</strong>
                                </p>
                            @endif

                        </div>
                        @error('data.destination_region_code')
                            <p class="mt-2 text-xs text-red-600" id="hs-validation-name-error-helper">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- End Section -->
            <label for="af-shipping-method" class="inline-block text-sm font-medium dark:text-white">
                Shipping Method
            </label>

            <div class="mt-2 space-y-3">
                <div class="grid space-y-2">
                    <div class="text-xs font-bold">
                        Regular
                    </div>
                    @foreach ($cart->items as $item)
                        <x-single-product-list :cart_item="$item" />
                    @endforeach
                    <div class="text-xs text-red-600">Fill Shipping Address First</div>
                </div>
            </div>

            <label for="af-payment-method" class="inline-block mt-5 text-sm font-medium dark:text-white">
                Payment Method
            </label>
            <div class="mt-2 space-y-3">
                <div class="grid space-y-2">
                    @php
                        $payment_methods = [
                            'Bank Transfer - BCA',
                            'Bank Transfer - BNI',
                            'Virtual Account BCA',
                            'QRIS',
                            'Dana',
                        ];
                    @endphp
                    @foreach ($payment_methods as $key => $item)
                        <label for="payment_method_{{ $key }}"
                            class="flex w-full p-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <input type="radio" name="hs-vertical-radio-in-form"
                                class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:cursor-default dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                id="payment_method_{{ $key }}">
                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">{{ $item }}</span>
                        </label>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="p-10">
            <h1 class="mb-5 text-2xl font-light">Order Summary</h1>

            <div>
                @foreach ($cart->items as $item)
                    <x-single-product-list :cart_item="$item" />
                @endforeach
            </div>

            <div class="grid gap-5">
                <!-- List Group -->
                <ul class="flex flex-col mt-3">
                    <li
                        class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                        <div class="flex items-center justify-between w-full">
                            <span>Sub Total</span>
                            <span>{{ data_get($this->summaries, 'sub_total_formatted') }}</span>
                        </div>
                    </li>
                    <li
                        class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                        <div class="flex items-center justify-between w-full">
                            <span class="flex flex-col">
                                <span>Shipping (JNT YES)</span>
                                <span class="text-xs">570 gram</span>
                            </span>
                            <span>{{ data_get($this->summaries, 'shipping_total_formatted') }}</span>
                        </div>
                    </li>
                    <li
                        class="inline-flex items-center px-4 py-3 -mt-px text-sm font-semibold text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200">
                        <div class="flex items-center justify-between w-full">
                            <span>Total</span>
                            <span>{{ data_get($this->summaries, 'grand_total_formatted') }}</span>
                        </div>
                    </li>
                </ul>

                <!-- End List Group -->
                <button type="button" wire:click="placeAnOrder" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg cursor-pointer hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:cursor-default">

                    <span wire:target="placeAnOrder" wire:loading class="inline-flex w-fit justify-center items-center">
                        {{-- loading spinner by preline ui --}}
                        <span
                            class="animate-spin inline-block translate-y-0.5 mr-1 size-4 border-2 border-current border-t-transparent text-white rounded-full dark:text-white"
                            role="status" aria-label="loading">
                        </span>
                        <span class="-translate-y-12">
                            Loading...
                        </span>
                    </span>

                    <span wire:target="placeAnOrder" wire:loading.remove>
                        Place an Order
                    </span>
                </button>

            </div>
        </div>
    </div>
</div>
