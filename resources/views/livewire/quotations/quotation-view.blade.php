<style>
    @media print {

        .quotation-document {
            margin-top: -40px;
        }

        /* Reduce spacing between quotation sections when printing */
        .quotation-document > :not([hidden]) ~ :not([hidden]) {
            margin-top: 8px !important;
        }

        /* Keep the footer close to the content above it */
        .quotation-document > .quotation-footer {
            margin-top: 8px !important;
        }

    }
</style>

<div class="quotation-document space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">

        {{-- Company Header --}}
        <div class="border-b-2 border-cyan-600 pb-3">
            <div class="text-2xl font-semibold text-cyan-600">
                Meissa Software Solutions Pvt. Ltd.
            </div>

            <div class="text-sm text-zinc-600">
                Aim To Provide Affordable Solutions
            </div>
        </div>

        {{-- View Controls --}}
        <div class="flex justify-end gap-2 print:hidden">

            <flux:button href="{{ route('quotations.edit', $quotation) }}" variant="ghost" wire:navigate> Edit </flux:button>

            <flux:button href="{{ route('quotations.pdf', $quotation) }}" target="_blank" variant="primary" class="print:hidden"> Generate PDF </flux:button>

            <flux:button href="{{ route('quotations') }}" variant="ghost" wire:navigate> Back </flux:button>

        </div>
    </div>



    {{-- Quotation Information --}}
    <flux:card>
        <table class="w-full text-sm">
            <tbody>
                <tr>
                    {{-- Date --}}
                    <td class="w-1/4 px-3 py-2 align-top">
                        <flux:heading size="sm">
                            Date
                        </flux:heading>

                        <flux:text class="mt-1">
                            {{ $quotation->quotation_date?->format('d M Y') }}
                        </flux:text>
                    </td>

                    {{-- Quote Number --}}
                    <td class="w-1/4 px-3 py-2 align-top">
                        <flux:heading size="sm">
                            Quote No.
                        </flux:heading>

                        <flux:text class="mt-1">
                            {{ $quotation->quotation_number }}
                        </flux:text>
                    </td>

                    {{-- Valid Until --}}
                    <td class="w-1/4 px-3 py-2 align-top">
                        <flux:heading size="sm">
                            Valid Until
                        </flux:heading>

                        <flux:text class="mt-1">
                            {{ $quotation->valid_until?->format('d M Y') ?? '—' }}
                        </flux:text>
                    </td>

                    {{-- Installation --}}
                    <td class="w-1/4 px-3 py-2 align-top">
                        <flux:heading size="sm">
                            Installation
                        </flux:heading>

                        <flux:text class="mt-1 whitespace-pre-line">
                            {{ $quotation->service_arrangement ?: '—' }}
                        </flux:text>
                    </td>
                </tr>
            </tbody>
        </table>
    </flux:card>



    {{-- Customer Details --}}
    <flux:card>
        <table class="w-full text-sm">
            <tbody>
                <tr>

                    {{-- Customer --}}
                    <td class="w-1/2 px-3 py-2 align-top">
                        <flux:heading size="sm">
                            To
                        </flux:heading>

                        <div class="mt-2">
                            <div class="font-medium">
                                {{ $quotation->customer->company_name }}
                            </div>

                            @if ($quotation->customer->contact_person)
                                <div class="text-zinc-600">
                                    {{ $quotation->customer->contact_person }}
                                </div>
                            @endif

                            <div class="mt-1 text-zinc-600">
                                @if ($quotation->customer->address_line1)
                                    {{ $quotation->customer->address_line1 }}<br>
                                @endif

                                @if ($quotation->customer->address_line2)
                                    {{ $quotation->customer->address_line2 }}<br>
                                @endif

                                @if ($quotation->customer->city)
                                    {{ $quotation->customer->city }}
                                @endif

                                @if ($quotation->customer->state)
                                    , {{ $quotation->customer->state }}
                                @endif

                                @if ($quotation->customer->pincode)
                                    - {{ $quotation->customer->pincode }}
                                @endif
                            </div>

                            @if ($quotation->customer->gstin)
                                <div class="mt-3 text-zinc-600">
                                    GSTIN: {{ $quotation->customer->gstin }}
                                </div>
                            @endif
                        </div>
                    </td>

                    {{-- Service Provider --}}
                    <td class="w-1/2 px-3 py-2 align-top">
                        <flux:heading size="sm">
                            Service Provider
                        </flux:heading>

                        <div class="mt-2">
                            <div class="font-medium">
                                Meissa Software Solutions Pvt. Ltd.
                            </div>

                            <div class="mt-1 text-zinc-600">
                                Ph: +91-9881124454
                            </div>

                            <div class="text-zinc-600">
                                support-meissa@meissa.co.in
                            </div>
                        </div>
                    </td>

                </tr>
            </tbody>
        </table>
    </flux:card>
    


    {{-- Quotation Items --}}
    <flux:card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-zinc-300 border-collapse">
                <thead>
                    <tr class="border-b-2 border-zinc-800">
                        <th class="px-3 py-3 text-center font-semibold">
                            S.No.
                        </th>

                        <th class="px-3 py-3 text-left font-semibold">
                            Description
                        </th>

                        <th class="px-3 py-3 text-left font-semibold">
                            Duration
                        </th>

                        <th class="px-3 py-3 text-right font-semibold">
                            Quantity
                        </th>

                        <th class="px-3 py-3 text-right font-semibold">
                            Price
                        </th>

                        <th class="px-3 py-3 text-right font-semibold">
                            Total Price
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($quotation->quotationItems as $index => $item)
                        <tr class="border-b border-zinc-300">
                            
                            {{-- S.No. --}}
                            <td class="px-3 py-3 text-center">
                                {{ $index + 1 }}
                            </td>

                            {{-- Description --}}
                            <td class="px-3 py-3">
                                <div class="font-medium">
                                    {{ $item->product->name }}
                                </div>

                                @if ($item->product->code)
                                    <div class="text-xs text-zinc-500">
                                        Code: {{ $item->product->code }}
                                    </div>
                                @endif

                                @if ($item->description)
                                    <div class="mt-1 text-sm text-zinc-600">
                                        {{ $item->description }}
                                    </div>
                                @endif
                            </td>

                            {{-- Duration --}}
                            <td class="px-3 py-3">
                                {{ $item->duration ?: '—' }}
                            </td>

                            {{-- Quantity --}}
                            <td class="px-3 py-3 text-right">
                                {{ number_format($item->quantity, 2) }}
                            </td>

                            {{-- Price --}}
                            <td class="px-3 py-3 text-right">
                                ₹{{ number_format($item->unit_price, 2) }}
                            </td>

                            {{-- Total Price --}}
                            <td class="px-3 py-3 text-right font-medium">
                                ₹{{ number_format($item->base_amount, 2) }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </flux:card>

    {{-- Quotation Summary --}}
    <div class="flex justify-end">

        <table class="w-full max-w-md text-sm">
            <tbody>

                {{-- Subtotal --}}
                <tr>
                    <td class="px-3 py-2">
                        Subtotal
                    </td>

                    <td class="px-3 py-2 text-right">
                        ₹{{ number_format($quotation->subtotal, 2) }}
                    </td>
                </tr>

                {{-- GST --}}
                <tr>
                    <td class="px-3 py-2">
                        GST
                        @if ($quotation->gst_applicable)
                            ({{ number_format($quotation->gst_rate, 2) }}%)
                        @endif
                    </td>

                    <td class="px-3 py-2 text-right">
                        ₹{{ number_format($quotation->gst_amount, 2) }}
                    </td>
                </tr>

                {{-- Grand Total --}}
                <tr class="border-t border-zinc-300">
                    <td class="px-3 py-3 font-semibold text-base">
                        Grand Total
                    </td>

                    <td class="px-3 py-3 text-right font-semibold text-base">
                        ₹{{ number_format($quotation->grand_total, 2) }}
                    </td>
                </tr>

            </tbody>
        </table>

    </div>



    

    {{-- Notes and Terms --}}
    <div class="text-sm">

        {{-- Notes --}}
        <div>
            <div class="font-semibold">
                Notes
            </div>

            <div class="mt-1 text-zinc-600 whitespace-pre-line">
                {{ $quotation->notes ?: '—' }}
            </div>
        </div>

        {{-- Terms & Conditions --}}
        <div class="mt-3">
            <div class="font-semibold">
                Terms & Conditions
            </div>

            <div class="mt-1 text-zinc-600 whitespace-pre-line">
                {{ $quotation->terms ?: '—' }}
            </div>
        </div>

    </div>


    {{-- Company Footer --}}
    <div class="quotation-footer border-t-2 border-cyan-600 pt-2 text-xs text-zinc-600">
        <div class="flex justify-between gap-6">
            <div>
                CIN: U72900PN2017PTC169478
            </div>

            <div class="text-right">
                RH24, Lake Paradise, Opp. CRPF, Talegaon Dabhade, Pune - 410507, MH
                    Ph: +91-9881124454
            </div>
        </div>
    </div>

</div>