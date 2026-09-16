<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]

class CustomerList extends Component
{
    public function render()
    {
        $customers = Customer::orderBy('company_name')->get();
        return view('livewire.customers.customer-list', [
            'customers' => $customers,
        ]);
    }
}
