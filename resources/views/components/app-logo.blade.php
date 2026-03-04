@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="GrocerSync" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-9 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <img src="/logo.png" alt="Logo" class="size-8 rounded-md">
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="GrocerSync" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-9 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <img src="/logo.png" alt="Logo" class="size-8 rounded-md">
        </x-slot>
    </flux:brand>
@endif
