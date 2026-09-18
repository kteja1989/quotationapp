<?php

namespace App\Livewire\Products;

use App\Models\Product;
Use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]

class ProductForm extends Component
{
    public ?Product $product = null;

    public string $code = '';

    public string $name = '';

    public string $description = '';

    public bool $is_active = true;

    public function mount(?Product $product = null): void
    {
        //$this->product = $product;

        //if ($product != null && $product->exists) {

        //    $this->product = $product;
            
        //    $this->code = $this->product->code;
        //    $this->name = $this->product->name;
        //    $this->description = $this->product->description;
        //    $this->is_active = (bool) $product->is_active;
        //}

        $this->product = $product;

        if ($product) {
            $this->code = $product->code;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->is_active = (bool) $product->is_active;
        }
    }

    protected function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->product) {
            $this->product->update($data);
        } else {
            Product::create($data);
        }

        $this->redirectRoute('products');
    }

    public function render()
    {
        return view('livewire.products.product-form');
    }
}