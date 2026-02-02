<?php

use function Livewire\Volt\computed;

$cartCount = computed(function () {
    return collect(session('cart', []))->sum('qty');
});

?>

<span class="absolute -top-1 -right-1 bg-red-600 text-white text-[11px] font-bold w-5 h-5 rounded-full flex items-center justify-center"
      wire:poll.2s>
    {{ $this->cartCount }}
</span>