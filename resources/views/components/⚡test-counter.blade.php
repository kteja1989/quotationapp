<?php

use Livewire\Component;

new class extends Component
{
    //
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }

    public function decrement(): void
    {
        $this->count--;
    }
};
?>

<div>
    <h1>Livewire Test</h1>

    <p>Count: {{ $count }}</p>

    <button wire:click="decrement">−</button>

    <button wire:click="increment">+</button>
</div>