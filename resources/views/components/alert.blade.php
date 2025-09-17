@props([
    'type' => session()->has('success') ? 'success' : (session()->has('error') ? 'error' : 'info'),
    'message' => session('success') ?? (session('error') ?? ''),

    // classes
    'successClasses' => 'bg-green-100 text-green-800',
    'errorClasses' => 'bg-red-100 text-red-800',
    'infoClasses' => 'bg-gray-100 text-gray-800',

    // icons
    'successIcon' => 'ep:success-filled',
    'errorIcon' => 'ep:circle-close-filled',
    'infoIcon' => 'ep:info-filled',
])

@if ($message || $errors->any())

    <div x-data="{ open: true, type: @js($type) }" class="alert">
        <div x-show="open" x-transition
            class="max-w-fit flex justify-center items-center py-3 px-4 bg-white rounded-xl border border-gray-200 shadow-sm mb-4 gap-2">

            <iconify-icon
                :icon="type === 'success' ? @js($successIcon) : (type === 'error' ? @js($errorIcon) :
                    @js($infoIcon))"
                width="20" height="20" class="text-green-500">
            </iconify-icon>


            <h5 class="font-medium text-gray-900 text-sm">
                {{-- if success --}}
                @if ($message)
                    {{ $message }}
                @endif

                {{-- if error --}}
                @if ($errors->any())
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </h5>

            <button @click="open = false" type="button"
                class="inline-flex ml-4 flex-shrink-0 justify-center text-gray-400 cursor-pointer hover:text-gray-600">
                <iconify-icon icon="material-symbols:close" width="20" height="20"></iconify-icon>
            </button>
        </div>
    </div>
@endif

<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
</div>
