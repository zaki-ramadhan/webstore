<a class="flex flex-col bg-white group rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70"
    href="{{ route('product', $product->slug) }}">
    <img class="object-cover rounded-2xl aspect-4/3"
        src={{ $product->cover_url }}
        alt={{ $product->name }}>
    <div class="py-5">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
            {{ $product->name }}
        </h3>
        <span class="text-sm text-gray-500 line-clamp-1">
            {{ $product->short_desc }}
        </span>
        <p class="mt-1 font-semibold text-black dark:text-black">
            {{ $product->price_formatted }}
        </p>
    </div>
</a>
