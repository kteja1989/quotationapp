<?php

namespace App\Livewire\Quotations;

use App\Models\Quotation;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class QuotationList extends Component
{
    public string $search = '';

    public string $status = 'all';

    public function render()
    {
        $quotations = Quotation::query()
            ->with(['customer','quotationItems.product'])
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('quotation_number', 'like', '%' . $this->search . '%')
                        ->orWhere('subject', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', function ($query) {
                            $query->where('company_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->orderByDesc('quotation_date')
            ->orderByDesc('id')
            ->get();

        return view('livewire.quotations.quotation-list', [
            'quotations' => $quotations,
        ]);
    }
}
