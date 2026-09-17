<div class="flex h-full w-full flex-1 flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Customers</flux:heading>

            <flux:text class="mt-2">
                Manage your customers and their contact information.
            </flux:text>
        </div>

        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

        <div class="w-full md:max-w-md">
            <flux:input
                wire:model.live="search"
                placeholder="Search customers..."
                icon="magnifying-glass"
            />
        </div>

            <div class="w-full md:w-48">
                <flux:select wire:model.live="status">
                    <flux:select.option value="all">All Customers</flux:select.option>
                    <flux:select.option value="active">Active</flux:select.option>
                    <flux:select.option value="inactive">Inactive</flux:select.option>
                </flux:select>
            </div>

        </div>

        <flux:button
            href="{{ route('customers.create') }}"
            variant="primary"
            wire:navigate
        >

           + Add Customer
        </flux:button>
    </div>

    {{-- Customer List --}}
    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

        @if ($customers->isEmpty())

            <div class="p-8 text-center">
                <flux:heading size="lg">No customers found</flux:heading>

                <flux:text class="mt-2">
                    You haven't added any customers yet.
                </flux:text>
            </div>

        @else

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 font-medium">Company Name</th>
                            <th class="px-6 py-3 font-medium">Contact Person</th>
                            <th class="px-6 py-3 font-medium">Email</th>
                            <th class="px-6 py-3 font-medium">Phone</th>
                            <th class="px-6 py-3 font-medium text-right">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($customers as $customer)
                            <tr class="border-b border-neutral-200 dark:border-neutral-700">
                                <td class="px-6 py-4">
                                    {{ $customer->company_name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $customer->contact_person ?? '—' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $customer->email ?? '—' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $customer->phone ?? '—' }}
                                </td>

                                <td class="px-6 py-4">
                                    @if ($customer->is_active)
                                        <flux:badge variant="success">Active</flux:badge>
                                    @else
                                        <flux:badge variant="danger">Inactive</flux:badge>
                                    @endif
                                </td>


                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">

                                        <flux:button
                                            href="{{ route('customers.edit', $customer) }}"
                                            variant="ghost"
                                            size="sm"
                                            wire:navigate
                                        >
                                            Edit
                                        </flux:button>

                                        @if ($customer->is_active)
                                            <flux:button
                                                variant="ghost"
                                                size="sm"
                                                wire:click="toggleStatus({{ $customer->id }})"
                                            >
                                                Deactivate
                                            </flux:button>
                                        @else
                                            <flux:button
                                                variant="ghost"
                                                size="sm"
                                                wire:click="toggleStatus({{ $customer->id }})"
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