<div class="flex h-full w-full flex-1 flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Customers</flux:heading>

            <flux:text class="mt-2">
                Manage your customers and their contact information.
            </flux:text>
        </div>

        <flux:button variant="primary">
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>

</div>