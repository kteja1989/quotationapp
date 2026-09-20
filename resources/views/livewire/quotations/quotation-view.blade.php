<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">
                View Quotation
            </flux:heading>

            <flux:text class="mt-1">
                {{ $quotation->quotation_number }}
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:button
                href="{{ route('quotations.edit', $quotation) }}"
                variant="ghost"
                wire:navigate
            >
                Edit
            </flux:button>

            <flux:button
                href="{{ route('quotations') }}"
                variant="ghost"
                wire:navigate
            >
                Back
            </flux:button>
        </div>
    </div>

    {{-- Quotation Details --}}
    <flux:card>
        <div class="grid gap-6 md:grid-cols-2">

            <div>
                <flux:heading size="sm">
                    Quotation Number
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->quotation_number }}
                </flux:text>
            </div>

            <div>
                <flux:heading size="sm">
                    Status
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->status }}
                </flux:text>
            </div>

            <div>
                <flux:heading size="sm">
                    Quotation Date
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->quotation_date?->format('d M Y') }}
                </flux:text>
            </div>

            <div>
                <flux:heading size="sm">
                    Valid Until
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->valid_until?->format('d M Y') ?? '—' }}
                </flux:text>
            </div>

        </div>
    </flux:card>

    {{-- Customer Details --}}
    <flux:card>
        <flux:heading size="lg">
            Customer Details
        </flux:heading>

        <div class="mt-4 grid gap-4 md:grid-cols-2">

            <div>
                <flux:heading size="sm">
                    Company
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->customer->company_name }}
                </flux:text>
            </div>

            <div>
                <flux:heading size="sm">
                    Contact Person
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->customer->contact_person ?: '—' }}
                </flux:text>
            </div>

            <div>
                <flux:heading size="sm">
                    Email
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->customer->email ?: '—' }}
                </flux:text>
            </div>

            <div>
                <flux:heading size="sm">
                    Phone
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->customer->phone ?: '—' }}
                </flux:text>
            </div>

            <div>
                <flux:heading size="sm">
                    Address
                </flux:heading>

                <flux:text class="mt-1 whitespace-pre-line">
                    {{ $quotation->customer->address_line1 ?: '—' }}
                    @if ($quotation->customer->address_line2)
                        {{ "\n" . $quotation->customer->address_line2 }}
                    @endif
                    @if ($quotation->customer->city)
                        {{ "\n" . $quotation->customer->city }}
                    @endif
                    @if ($quotation->customer->state)
                        {{ ", " . $quotation->customer->state }}
                    @endif
                    @if ($quotation->customer->pincode)
                        {{ " - " . $quotation->customer->pincode }}
                    @endif
                </flux:text>
            </div>

            <div>
                <flux:heading size="sm">
                    GSTIN
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->customer->gstin ?: '—' }}
                </flux:text>
            </div>

        </div>
    </flux:card>

        {{-- Quotation Information --}}
    <flux:card>
        <flux:heading size="lg">
            Quotation Information
        </flux:heading>

        <div class="mt-4 space-y-4">

            <div>
                <flux:heading size="sm">
                    Subject
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $quotation->subject ?: '—' }}
                </flux:text>
            </div>

            <div>
                <flux:heading size="sm">
                    Service Arrangement
                </flux:heading>

                <flux:text class="mt-1 whitespace-pre-line">
                    {{ $quotation->service_arrangement ?: '—' }}
                </flux:text>
            </div>

        </div>
    </flux:card>

    {{-- Quotation Items --}}
    <flux:card>
        <flux:heading size="lg">
            Quotation Items
        </flux:heading>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="px-3 py-3 text-left">Product / Service</th>
                        <th class="px-3 py-3 text-left">Description</th>
                        <th class="px-3 py-3 text-left">Duration</th>
                        <th class="px-3 py-3 text-right">Qty</th>
                        <th class="px-3 py-3 text-right">Unit Price</th>
                        <th class="px-3 py-3 text-right">Base Amount</th>
                        <th class="px-3 py-3 text-right">GST</th>
                        <th class="px-3 py-3 text-right">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($quotation->quotationItems as $item)
                        <tr class="border-b">
                            <td class="px-3 py-3">
                                <div class="font-medium">
                                    {{ $item->product->name }}
                                </div>

                                <div class="text-xs text-zinc-500">
                                    {{ $item->product->code }}
                                </div>
                            </td>

                            <td class="px-3 py-3">
                                {{ $item->description ?: '—' }}
                            </td>

                            <td class="px-3 py-3">
                                {{ $item->duration ?: '—' }}
                            </td>

                            <td class="px-3 py-3 text-right">
                                {{ number_format($item->quantity, 2) }}
                            </td>

                            <td class="px-3 py-3 text-right">
                                ₹{{ number_format($item->unit_price, 2) }}
                            </td>

                            <td class="px-3 py-3 text-right">
                                ₹{{ number_format($item->base_amount, 2) }}
                            </td>

                            <td class="px-3 py-3 text-right">
                                ₹{{ number_format($item->gst_amount, 2) }}
                            </td>

                            <td class="px-3 py-3 text-right font-medium">
                                ₹{{ number_format($item->total_amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </flux:card>

        {{-- Quotation Summary --}}
    <flux:card>
        <div class="flex justify-end">
            <div class="w-full max-w-md space-y-3">

                <div class="flex justify-between">
                    <flux:text>
                        Subtotal
                    </flux:text>

                    <flux:text>
                        ₹{{ number_format($quotation->subtotal, 2) }}
                    </flux:text>
                </div>

                <div class="flex justify-between">
                    <flux:text>
                        GST
                    </flux:text>

                    <flux:text>
                        ₹{{ number_format($quotation->gst_amount, 2) }}
                    </flux:text>
                </div>

                <div class="border-t pt-3 flex justify-between">
                    <flux:heading size="lg">
                        Grand Total
                    </flux:heading>

                    <flux:heading size="lg">
                        ₹{{ number_format($quotation->grand_total, 2) }}
                    </flux:heading>
                </div>

            </div>
        </div>
    </flux:card>

    {{-- Notes and Terms --}}
    <flux:card>
        <div class="space-y-6">

            <div>
                <flux:heading size="lg">
                    Notes
                </flux:heading>

                <flux:text class="mt-2 whitespace-pre-line">
                    {{ $quotation->notes ?: '—' }}
                </flux:text>
            </div>

            <div>
                <flux:heading size="lg">
                    Terms & Conditions
                </flux:heading>

                <flux:text class="mt-2 whitespace-pre-line">
                    {{ $quotation->terms ?: '—' }}
                </flux:text>
            </div>

        </div>
    </flux:card>

</div>