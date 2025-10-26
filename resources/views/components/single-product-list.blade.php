@props(['cart_item'])

<div class="flex items-center gap-2 border-b border-gray-200">
    <div class="relative overflow-hidden rounded-md h-15 w-15">
        <img class="object-coversize-full"
        src="{{ $cart_item->product()->cover_url }}"
        alt="Product Name">
    </div>
    <div class="flex items-center">
        <div class="py-2">
            <h3 class="text-gray-800 text-md dark:text-white">
                {{ $cart_item->product()->name }}
            </h3>
            <h2 class="text-sm text-gray-500">
                {{ $cart_item->product()->short_desc }}
            </h2>
            <p class="mt-1 text-sm text-black text-md dark:text-black">
                {{ $cart_item->product()->price_formatted }} x {{ $cart_item->quantity }}
            </p>
        </div>
    </div>
</div>
