<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.app')]
class ProductList extends Component
{

    public string $search = '';

    public string $status = 'all';

    public function toggleStatus(int $productId): void
    {
        $product = Product::findOrFail($productId);

        $product->update([
            'is_active' => ! $product->is_active,
        ]);

    }
    public function render()
    {
        $products = Product::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('is_active', $this->status === 'active');
            })
            ->orderBy('name')
            ->get();

        return view('livewire.products.product-list', [
            'products' => $products,
        ]);
    }
}