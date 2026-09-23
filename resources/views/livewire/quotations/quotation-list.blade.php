<div class="flex h-full w-full flex-1 flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <flux:heading size="xl">Quotations</flux:heading>

            <flux:text class="mt-2">
                Create and manage customer quotations.
            </flux:text>
        </div>
            <flux:button href="{{ route('quotations.create') }}" variant="primary" wire:navigate> + New Quotation </flux:button>
    </div>

    {{-- Search and Filter --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

        <div class="w-full md:max-w-md">
            <flux:input
                wire:model.live="search"
                placeholder="Search quotations..."
                icon="magnifying-glass"
            />
        </div>

        <div class="w-full md:w-48">
            <flux:select wire:model.live="status">
                <flux:select.option value="all">
                    All Quotations
                </flux:select.option>

                <flux:select.option value="Draft">
                    Draft
                </flux:select.option>

                <flux:select.option value="Sent">
                    Sent
                </flux:select.option>

                <flux:select.option value="Accepted">
                    Accepted
                </flux:select.option>

                <flux:select.option value="Rejected">
                    Rejected
                </flux:select.option>

                <flux:select.option value="Expired">
                    Expired
                </flux:select.option>

            </flux:select>
        </div>

    </div>

    {{-- Quotation List --}}
    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

        @if ($quotations->isEmpty())

            <div class="p-8 text-center">
                <flux:heading size="lg">
                    No quotations found
                </flux:heading>

                <flux:text class="mt-2">
                    Create your first quotation to get started.
                </flux:text>
            </div>

        @else

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">
                                Quotation No.
                            </th>

                            <th class="px-6 py-3 text-left font-medium">
                                Customer
                            </th>

                            <th class="px-6 py-3 text-left font-medium">
                                Product / Service
                            </th>

                            <th class="px-6 py-3 text-left font-medium">
                                Subject
                            </th>

                            <th class="px-6 py-3 text-left font-medium">
                                Date
                            </th>

                            <th class="px-6 py-3 text-right font-medium">
                                Grand Total
                            </th>

                            <th class="px-6 py-3 text-center font-medium">
                                Status
                            </th>

                            <th class="px-6 py-3 text-right font-medium">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">

                        @foreach ($quotations as $quotation)

                            <tr>

                                <td class="px-6 py-4 font-medium">
                                    {{ $quotation->quotation_number }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $quotation->customer->company_name }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @foreach ($quotation->quotationItems as $item)
                                            <div>
                                                {{ $item->product->code }} — {{ $item->product->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    {{ $quotation->subject ?: '—' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $quotation->quotation_date?->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    ₹{{ number_format($quotation->grand_total, 2) }}
                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if ($quotation->status === 'Draft')

                                        <flux:badge>
                                            Draft
                                        </flux:badge>

                                    @elseif ($quotation->status === 'Sent')

                                        <flux:badge variant="info">
                                            Sent
                                        </flux:badge>

                                    @elseif ($quotation->status === 'Accepted')

                                        <flux:badge variant="success">
                                            Accepted
                                        </flux:badge>

                                    @elseif ($quotation->status === 'Rejected')

                                        <flux:badge variant="danger">
                                            Rejected
                                        </flux:badge>

                                    @elseif ($quotation->status === 'Expired')

                                        <flux:badge variant="warning">
                                            Expired
                                        </flux:badge>

                                    @endif

                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">

                                        <flux:button href="{{ route('quotations.view', $quotation) }}" variant="ghost" size="sm" wire:navigate> View </flux:button>

                                        <flux:button href="{{ route('quotations.edit', $quotation) }}" variant="ghost" size="sm" wire:navigate> Edit </flux:button>

                                        <flux:button href="{{ route('quotations.pdf', $quotation) }}" variant="ghost" size="sm" target="_blank"> PDF </flux:button>

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

        @endif

    </div>

</div>