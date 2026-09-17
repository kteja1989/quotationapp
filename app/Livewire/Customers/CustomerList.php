<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]

class CustomerList extends Component
{


    public string $search = '';

    public string $status = 'all';

    public function toggleStatus(int $customerId): void
    {
        $customer = Customer::findOrFail($customerId);

        $customer->update([
            'is_active' => ! $customer->is_active,
        ]);
    }

    public function render()
    {
        $customers = Customer::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('company_name', 'like', '%' . $this->search . '%')
                        ->orWhere('contact_person', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('is_active', $this->status === 'active');
            })
            ->orderBy('company_name')
            ->get();

        return view('livewire.customers.customer-list', [
            'customers' => $customers,
        ]);
    }
}