<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]

class CustomerForm extends Component
{
    public ?Customer $customer = null;

    public string $company_name = '';

    public string $contact_person = '';

    public string $email = '';

    public string $phone = '';

    public string $address_line1 = '';

    public string $address_line2 = '';

    public string $city = '';

    public string $state = '';

    public string $pincode = '';

    public string $gstin = '';

    public bool $is_active = true;

    public function mount(?Customer $customer = null): void
    {
        if ($customer !== null && $customer->exists) {

            $this->customer = $customer;
            $this->company_name = $customer->company_name;
            $this->contact_person = $customer->contact_person ?? '';
            $this->email = $customer->email ?? '';
            $this->phone = $customer->phone ?? '';
            $this->address_line1 = $customer->address_line1 ?? '';
            $this->address_line2 = $customer->address_line2 ?? '';
            $this->city = $customer->city ?? '';
            $this->state = $customer->state ?? '';
            $this->pincode = $customer->pincode ?? '';
            $this->gstin = $customer->gstin ?? '';
            $this->is_active = (bool) $customer->is_active;
        }
    }


    protected function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:10'],
            'gstin' => ['nullable', 'string', 'max:15'],
            'is_active' => ['boolean'],
        ];
    }
/*
    public function save(): void
    {
        $this->validate();


        Customer::create([
            'company_name' => $this->company_name,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone' => $this->phone,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
            'gstin' => $this->gstin,
            'is_active' => $this->is_active,
        ]);

        $this->redirectRoute('customers');

        // Handle form submission logic here, e.g., save the customer data to the database.

        // Reset the form fields after successful submission
        $this->reset();
    }
*/

    public function save(): void
    {
        $this->validate();

        $data = [
            'company_name' => $this->company_name,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone' => $this->phone,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
            'gstin' => $this->gstin,
            'is_active' => $this->is_active,
        ];

        if ($this->customer) {

            $this->customer->update($data);

        } else {

            Customer::create($data);
        }

        $this->redirectRoute('customers');

        // Handle form submission logic here, e.g., save the customer data to the database.

        // Reset the form fields after successful submission

        $this->reset();
    }

    public function render()
    {
        return view('livewire.customers.customer-form');
    }
}