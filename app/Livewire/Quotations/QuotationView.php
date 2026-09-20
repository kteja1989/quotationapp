<?php

namespace App\Livewire\Quotations;

use App\Models\Quotation;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]

class QuotationView extends Component
{
    public Quotation $quotation;

    public function mount(Quotation $quotation): void
    {
        $this->quotation = $quotation->load([
            'customer',
            'quotationItems.product',
        ]);
    }

    public function render()
    {
        return view('livewire.quotations.quotation-view');
    }
}
