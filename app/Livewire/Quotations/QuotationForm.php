<?php

namespace App\Livewire\Quotations;

use Illuminate\Support\Facades\DB;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Quotation;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class QuotationForm extends Component
{
    /*
    |--------------------------------------------------------------------------
    | Quotation Details
    |--------------------------------------------------------------------------
    */

    public ?Quotation $quotation = null;

    public string $status = 'Draft';

    public ?int $customer_id = null;

    public string $quotation_date = '';

    public string $valid_until = '';

    public string $subject = '';

    public string $service_arrangement = '';

    public string $notes = '';

    public string $terms = '';

    /*
    |--------------------------------------------------------------------------
    | GST
    |--------------------------------------------------------------------------
    */

    public bool $gst_applicable = true;

    public float $gst_rate = 18.00;

    /*
    |--------------------------------------------------------------------------
    | Quotation Items
    |--------------------------------------------------------------------------
    */

    public array $items = [];

    /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

    public float $subtotal = 0;

    public float $gst_amount = 0;

    public float $grand_total = 0;

    /*
    |--------------------------------------------------------------------------
    | Form Initialization
    |--------------------------------------------------------------------------
    */

    public function mount(?Quotation $quotation = null): void
    {
        $this->quotation_date = now()->format('Y-m-d');

        if ($quotation !== null && $quotation->exists) {
            $this->quotation = $quotation;

            $this->customer_id = $quotation->customer_id;
            $this->status = $quotation->status ?? 'Draft';
            $this->quotation_date = $quotation->quotation_date?->format('Y-m-d') ?? '';
            $this->valid_until = $quotation->valid_until?->format('Y-m-d') ?? '';
            $this->subject = $quotation->subject ?? '';
            $this->service_arrangement = $quotation->service_arrangement ?? '';
            $this->notes = $quotation->notes ?? '';
            $this->terms = $quotation->terms ?? '';
            $this->gst_applicable = (bool) $quotation->gst_applicable;
            $this->gst_rate = (float) $quotation->gst_rate;

            $this->items = $quotation->quotationItems
                ->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'description' => $item->description ?? '',
                        'duration' => $item->duration ?? '',
                        'quantity' => (float) $item->quantity,
                        'unit_price' => (float) $item->unit_price,
                        'base_amount' => (float) $item->base_amount,
                        'gst_rate' => (float) $item->gst_rate,
                        'gst_amount' => (float) $item->gst_amount,
                        'total_amount' => (float) $item->total_amount,
                    ];
                })
                ->toArray();

            $this->calculateTotals();

        } else {
            $this->items = [
                [
                    'product_id' => null,
                    'description' => '',
                    'duration' => '',
                    'quantity' => 1,
                    'unit_price' => 0,
                    'base_amount' => 0,
                    'gst_rate' => 18,
                    'gst_amount' => 0,
                    'total_amount' => 0,
                ],
            ];
        }
    }

    private function generateQuotationNumber(): string
    {
        $year = now()->year;

        $lastQuotation = Quotation::query()
            ->whereYear('quotation_date', $year)
            ->orderByDesc('id')
            ->first();

        if ($lastQuotation === null) {
            $sequence = 1;
        } else {
            $lastNumber = (int) substr(
                $lastQuotation->quotation_number,
                -4
            );

            $sequence = $lastNumber + 1;
        }

        return sprintf(
            'QT-%d-%04d',
            $year,
            $sequence
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Save Quotation
    |--------------------------------------------------------------------------
    */

    public function save(): void
    {
        $this->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'quotation_date' => ['required', 'date'],
            'valid_until' => [
                'nullable',
                'date',
                'after_or_equal:quotation_date',
            ],
            'subject' => ['nullable', 'string', 'max:255'],
            'service_arrangement' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'terms' => ['nullable', 'string'],

            'status' => [
                'required',
                'in:Draft,Sent,Accepted,Rejected,Expired',
            ],
            
            'gst_applicable' => ['boolean'],
            'gst_rate' => ['required', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required',
                'exists:products,id',
            ],
            'items.*.description' => ['nullable', 'string'],
            'items.*.duration' => [
                'nullable',
                'string',
                'max:255',
            ],
            'items.*.quantity' => [
                'required',
                'numeric',
                'gt:0',
            ],
            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $this->calculateTotals();

        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | Update Existing Quotation
            |--------------------------------------------------------------------------
            */

            if ($this->quotation !== null && $this->quotation->exists) {

                $this->quotation->update([
                    'customer_id' => $this->customer_id,
                    'quotation_date' => $this->quotation_date,
                    'valid_until' => $this->valid_until ?: null,
                    'subject' => $this->subject,
                    'service_arrangement' => $this->service_arrangement,
                    'notes' => $this->notes,
                    'terms' => $this->terms,
                    'status' => $this->status,

                    'gst_applicable' => $this->gst_applicable,
                    'gst_rate' => $this->gst_applicable
                        ? $this->gst_rate
                        : 0,

                    'subtotal' => $this->subtotal,
                    'gst_amount' => $this->gst_amount,
                    'grand_total' => $this->grand_total,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Replace Existing Quotation Items
                |--------------------------------------------------------------------------
                */

                $this->quotation->quotationItems()->delete();

                foreach ($this->items as $item) {

                    $this->quotation->quotationItems()->create([
                        'product_id' => $item['product_id'],
                        'description' => $item['description'] ?? '',
                        'duration' => $item['duration'] ?? '',
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'base_amount' => $item['base_amount'],

                        'gst_rate' => $this->gst_applicable
                            ? $this->gst_rate
                            : 0,

                        'gst_amount' => $item['gst_amount'],
                        'total_amount' => $item['total_amount'],
                    ]);
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | Create New Quotation
                |--------------------------------------------------------------------------
                */

                $quotation = Quotation::create([
                    'quotation_number' => $this->generateQuotationNumber(),
                    'customer_id' => $this->customer_id,
                    'quotation_date' => $this->quotation_date,
                    'valid_until' => $this->valid_until ?: null,
                    'subject' => $this->subject,
                    'service_arrangement' => $this->service_arrangement,
                    'notes' => $this->notes,
                    'terms' => $this->terms,

                    'gst_applicable' => $this->gst_applicable,
                    'gst_rate' => $this->gst_applicable
                        ? $this->gst_rate
                        : 0,

                    'subtotal' => $this->subtotal,
                    'gst_amount' => $this->gst_amount,
                    'grand_total' => $this->grand_total,

                    // New quotations always start as Draft.
                    'status' => 'Draft',
                ]);

                foreach ($this->items as $item) {

                    $quotation->quotationItems()->create([
                        'product_id' => $item['product_id'],
                        'description' => $item['description'] ?? '',
                        'duration' => $item['duration'] ?? '',
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'base_amount' => $item['base_amount'],

                        'gst_rate' => $this->gst_applicable
                            ? $this->gst_rate
                            : 0,

                        'gst_amount' => $item['gst_amount'],
                        'total_amount' => $item['total_amount'],
                    ]);
                }

                $this->quotation = $quotation;
            }
        });

        $this->redirectRoute('quotations');
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view('livewire.quotations.quotation-form', [
            'customers' => Customer::query()
                ->where('is_active', true)
                ->orderBy('company_name')
                ->get(),

            'products' => Product::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Quotation Items
    |--------------------------------------------------------------------------
    */

    public function addItem(): void
    {
        $this->items[] = [
            'product_id' => null,
            'description' => '',
            'duration' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'base_amount' => 0,

            'gst_rate' => $this->gst_applicable
                ? (float) $this->gst_rate
                : 0,

            'gst_amount' => 0,
            'total_amount' => 0,
        ];
    }

    public function removeItem(int $index): void
    {
        if (count($this->items) <= 1) {
            return;
        }

        unset($this->items[$index]);

        $this->items = array_values($this->items);

        $this->calculateTotals();
    }

    /*
    |--------------------------------------------------------------------------
    | Livewire Updates
    |--------------------------------------------------------------------------
    */

    public function updatedItems($value, $key): void
    {
        $parts = explode('.', $key);

        if (
            count($parts) === 2 &&
            $parts[1] === 'product_id'
        ) {
            $index = (int) $parts[0];

            $productId = $this->items[$index]['product_id'] ?? null;

            if ($productId) {
                $product = Product::find($productId);

                if ($product) {
                    $this->items[$index]['description'] =
                        $product->description ?? '';
                }
            }
        }

        if (
            count($parts) === 2 &&
            in_array(
                $parts[1],
                ['quantity', 'unit_price'],
                true
            )
        ) {
            $this->calculateTotals();
        }
    }


    /*
    public function updatedStatus($value): void
    {
        $this->status = $value;
    }
    
    */
    public function updatedGstApplicable(): void
    {
        $this->calculateTotals();
    }

    public function updatedGstRate(): void
    {
        if ($this->gst_applicable) {
            $this->calculateTotals();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | //Calculations
    |--------------------------------------------------------------------------
    */

    public function calculateTotals(): void
    {
        $this->subtotal = 0;
        $this->gst_amount = 0;

        foreach ($this->items as $index => $item) {

            $quantity = (float) ($item['quantity'] ?? 0);

            $unitPrice = (float) ($item['unit_price'] ?? 0);

            $baseAmount = $quantity * $unitPrice;

            $gstAmount = 0;

            if ($this->gst_applicable) {
                $gstAmount = $baseAmount *
                    ((float) $this->gst_rate / 100);
            }

            $totalAmount = $baseAmount + $gstAmount;

            $this->items[$index]['base_amount'] =
                round($baseAmount, 2);

            $this->items[$index]['gst_rate'] =
                $this->gst_applicable
                    ? (float) $this->gst_rate
                    : 0;

            $this->items[$index]['gst_amount'] =
                round($gstAmount, 2);

            $this->items[$index]['total_amount'] =
                round($totalAmount, 2);

            $this->subtotal += $baseAmount;

            $this->gst_amount += $gstAmount;
        }

        $this->subtotal = round($this->subtotal, 2);

        $this->gst_amount = round($this->gst_amount, 2);

        $this->grand_total = round(
            $this->subtotal + $this->gst_amount,
            2
        );
    }
}