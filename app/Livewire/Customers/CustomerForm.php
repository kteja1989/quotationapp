<?php

namespace App\Livewire\Customers;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]

class CustomerForm extends Component
{
    public function render()
    {
        return view('livewire.customers.customer-form');
    }
}