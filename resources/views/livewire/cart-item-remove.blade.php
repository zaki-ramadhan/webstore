<button type="button" wire:loading.attr="disabled" wire:click="remove" wire:loading.class=" border-red-400" class="inline-flex items-center justify-center ml-auto px-[0.45rem] py-0.5 text-sm font-medium text-red-500 border-[1.35px] border-transparent rounded-lg cursor-pointer gap-x-2 hover:bg-slate-50 hover:border-red-400 active:outline-hidden active:bg-slate-100 disabled:opacity-50 disabled:pointer-events-none disabled:px-3 disabled:py-2 disabled:border-red-400/70">
    <span wire:target="remove" wire:loading class="flex justify-center items-center">
        {{-- loading spinner by preline ui --}}
        <span
            class="animate-spin inline-block translate-y-0.5 mr-1 size-4 border-2 border-current border-t-transparent text-red-500 rounded-full dark:text-red-500"
            role="status" aria-label="loading">
        </span>
        <span class="-translate-y-10 ml-1">
            Deleting...
        </span>
    </span>

    <span wire:target="remove" wire:loading.remove>
        <iconify-icon icon="fluent:delete-28-regular" width="24" height="24" class="mt-1"></iconify-icon>
        {{-- Delete --}}
    </span>
</button>
