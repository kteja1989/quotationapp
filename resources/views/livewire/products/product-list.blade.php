<div class="flex h-full w-full flex-1 flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <flux:heading size="xl">Products & Services</flux:heading>

            <flux:text class="mt-2">
                Manage the products and services available for quotations.
            </flux:text>
        </div>

        <flux:button href="{{ route('products.create') }}" variant="primary" wire:navigate> + Add Product </flux:button>
    </div>

    {{-- Search and Filter --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

        <div class="w-full md:max-w-md">
            <flux:input
                wire:model.live="search"
                placeholder="Search products..."
                icon="magnifying-glass"
            />
        </div>

        <div class="w-full md:w-48">
            <flux:select wire:model.live="status">
                <flux:select.option value="all">
                    All Products
                </flux:select.option>

                <flux:select.option value="active">
                    Active
                </flux:select.option>

                <flux:select.option value="inactive">
                    Inactive
                </flux:select.option>
            </flux:select>
        </div>

    </div>

    {{-- Product List --}}
    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

        @if ($products->isEmpty())

            <div class="p-8 text-center">
                <flux:heading size="lg">
                    No products found
                </flux:heading>

                <flux:text class="mt-2">
                    Add your first product or service to start using it in quotations.
                </flux:text>
            </div>

        @else

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">
                                Code
                            </th>

                            <th class="px-6 py-3 text-left font-medium">
                                Product / Service
                            </th>

                            <th class="px-6 py-3 text-left font-medium">
                                Description
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

                        @foreach ($products as $product)

                            <tr>
                                <td class="px-6 py-4 font-medium">
                                    {{ $product->code }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $product->name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $product->description ?: '—' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if ($product->is_active)
                                        <flux:badge variant="success">
                                            Active
                                        </flux:badge>
                                    @else
                                        <flux:badge variant="danger">
                                            Inactive
                                        </flux:badge>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">

                                        <flux:button
                                            href="{{ route('products.edit', $product) }}"
                                            variant="ghost"
                                            size="sm"
                                            wire:navigate
                                        >
                                            Edit
                                        </flux:button>

                                        @if ($product->is_active)

                                            <flux:button
                                                variant="ghost"
                                                size="sm"
                                                wire:click="toggleStatus({{ $product->id }})"
                                            >
                                                Deactivate
                                            </flux:button>

                                        @else

                                            <flux:button
                                                variant="ghost"
                                                size="sm"
                                                wire:click="toggleStatus({{ $product->id }})"
                                            >
                                                Activate
                                            </flux:button>

                                        @endif

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