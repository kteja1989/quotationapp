<div class="flex h-full w-full flex-1 flex-col gap-6">

    {{-- Page Header --}}
    <div>
        <flux:heading size="xl">New Quotation</flux:heading>

        <flux:text class="mt-2">
            Create a quotation for a customer.
        </flux:text>
    </div>

    {{-- Quotation Details --}}
    <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

        <flux:heading size="lg">Quotation Details</flux:heading>

        <div class="mt-6 space-y-6">

            <flux:select
                wire:model="customer_id"
                label="Customer"
                placeholder="Select customer"
            >
                <flux:select.option value="">
                    Select a customer
                </flux:select.option>

                @foreach ($customers as $customer)
                    <flux:select.option value="{{ $customer->id }}">
                        {{ $customer->company_name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <div class="grid gap-6 md:grid-cols-2">

                <flux:input
                    wire:model="quotation_date"
                    type="date"
                    label="Quotation Date"
                />

                <flux:input
                    wire:model="valid_until"
                    type="date"
                    label="Valid Until"
                />

            </div>

            <flux:input
                wire:model="subject"
                label="Subject"
                placeholder="Enter quotation subject"
            />

            <flux:textarea
                wire:model="service_arrangement"
                label="Service Arrangement"
                placeholder="Describe the service / installation arrangement"
            />

        </div>

    </div>

    {{-- Quotation Items --}}
    <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

        <div class="flex items-center justify-between gap-4">

            <div>
                <flux:heading size="lg">
                    Quotation Items
                </flux:heading>

                <flux:text class="mt-1">
                    Add the products or services included in this quotation.
                </flux:text>
            </div>

            <flux:button
                type="button"
                variant="primary"
                wire:click="addItem"
            >
                + Add Item
            </flux:button>

        </div>

        <div class="mt-6 space-y-6">

            @foreach ($items as $index => $item)

                <div
                    wire:key="quotation-item-{{ $index }}"
                    class="rounded-lg border border-neutral-200 p-5 dark:border-neutral-700"
                >

                    <div class="flex items-center justify-between gap-4">

                        <flux:heading size="sm">
                            Item {{ $index + 1 }}
                        </flux:heading>

                        @if (count($items) > 1)

                            <flux:button
                                type="button"
                                variant="ghost"
                                size="sm"
                                wire:click="removeItem({{ $index }})"
                            >
                                Remove
                            </flux:button>

                        @endif

                    </div>

                    <div class="mt-5 grid gap-6 md:grid-cols-2">

                        {{-- Product --}}
                        <flux:select
                            wire:model.live="items.{{ $index }}.product_id"
                            label="Product / Service"
                        >
                            <flux:select.option value="">
                                Select a product or service
                            </flux:select.option>

                            @foreach ($products as $product)
                                <flux:select.option value="{{ $product->id }}">
                                    {{ $product->code }} — {{ $product->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>

                        {{-- Duration --}}
                        <flux:input
                            wire:model="items.{{ $index }}.duration"
                            label="Duration"
                            placeholder="e.g. 12 Months"
                        />

                    </div>

                    <div class="mt-6">

                        <flux:textarea
                            wire:model="items.{{ $index }}.description"
                            label="Description"
                            placeholder="Enter item description"
                        />

                    </div>

                    <div class="mt-6 grid gap-6 md:grid-cols-3">

                        {{-- Quantity --}}
                        <flux:input
                            wire:model.live="items.{{ $index }}.quantity"
                            type="number"
                            min="0"
                            step="0.01"
                            label="Quantity"
                        />

                        {{-- Unit Price --}}
                        <flux:input
                            wire:model.live="items.{{ $index }}.unit_price"
                            type="number"
                            min="0"
                            step="0.01"
                            label="Unit Price"
                        />

                        {{-- Base Amount --}}
                        <flux:input
                            value="{{ number_format($item['base_amount'] ?? 0, 2, '.', '') }}"
                            label="Base Amount"
                            readonly
                        />

                    </div>

                    <div class="mt-6 grid gap-6 md:grid-cols-3">

                        {{-- GST Rate --}}
                        <flux:input
                            value="{{ number_format($item['gst_rate'] ?? 0, 2, '.', '') }}%"
                            label="GST Rate"
                            readonly
                        />

                        {{-- GST Amount --}}
                        <flux:input
                            value="{{ number_format($item['gst_amount'] ?? 0, 2, '.', '') }}"
                            label="GST Amount"
                            readonly
                        />

                        {{-- Total Amount --}}
                        <flux:input
                            value="{{ number_format($item['total_amount'] ?? 0, 2, '.', '') }}"
                            label="Total Amount"
                            readonly
                        />

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    {{-- GST Settings --}}
    <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

        <flux:heading size="lg">
            Tax / GST
        </flux:heading>

        <div class="mt-6 grid gap-6 md:grid-cols-2">

            <div class="flex items-center">
                <flux:checkbox
                    wire:model.live="gst_applicable"
                    label="GST Applicable"
                />
            </div>

            @if ($gst_applicable)

                <flux:input
                    wire:model.live="gst_rate"
                    type="number"
                    min="0"
                    step="0.01"
                    label="GST Rate (%)"
                />

            @endif

        </div>

    </div>

    {{-- Totals --}}
    <div class="flex justify-end">

        <div class="w-full max-w-md rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

            <flux:heading size="lg">
                Quotation Summary
            </flux:heading>

            <div class="mt-5 space-y-3">

                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>
                        ₹{{ number_format($subtotal, 2) }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span>
                        GST
                        @if ($gst_applicable)
                            ({{ number_format($gst_rate, 2) }}%)
                        @endif
                    </span>

                    <span>
                        ₹{{ number_format($gst_amount, 2) }}
                    </span>
                </div>

                <div class="border-t border-neutral-200 pt-3 dark:border-neutral-700">

                    <div class="flex justify-between text-lg font-semibold">

                        <span>Grand Total</span>

                        <span>
                            ₹{{ number_format($grand_total, 2) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3">

        <flux:button href="{{ route('quotations') }}" variant="ghost" wire:navigate> Cancel </flux:button>
        <flux:button variant="primary" type="button" wire:click="save"> Save Quotation </flux:button>

    </div>

</div>