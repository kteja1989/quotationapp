<div class="flex h-full w-full flex-1 flex-col gap-6">

    {{-- Page Header --}}
    <div>
        <flux:heading size="xl">Add Customer</flux:heading>

        <flux:text class="mt-2">
            Enter the customer's company and contact information.
        </flux:text>
    </div>

    {{-- Company Information --}}
    <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

        <flux:heading size="lg">Company Information</flux:heading>

        <div class="mt-6 grid gap-6 md:grid-cols-2">

            <flux:input
                wire:model="company_name"
                label="Company Name"
                placeholder="Enter company name"
                :error="$errors->first('company_name')"
            />

            <flux:input
                wire:model="contact_person"
                label="Contact Person"
                placeholder="Enter contact person's name"
            />

        </div>
    </div>

    {{-- Contact Information --}}
    <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

        <flux:heading size="lg">Contact Information</flux:heading>

        <div class="mt-6 grid gap-6 md:grid-cols-2">

            <flux:input
                wire:model="email"
                type="email"
                label="Email"
                placeholder="Enter email address"
                :error="$errors->first('email')"
            />

            <flux:input
                wire:model="phone"
                label="Phone"
                placeholder="Enter phone number"
                :error="$errors->first('phone')"
            />

        </div>
    </div>

    {{-- Address --}}
    <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

        <flux:heading size="lg">Address</flux:heading>

        <div class="mt-6 space-y-6">

            <flux:input
                wire:model="address_line1"
                label="Address Line 1"
                placeholder="Enter address"
                :error="$errors->first('address_line1')"
            />

            <flux:input
                wire:model="address_line2"
                label="Address Line 2"
                placeholder="Apartment, building, landmark, etc."
                :error="$errors->first('address_line2')"
            />

            <div class="grid gap-6 md:grid-cols-3">

                <flux:input
                    wire:model="city"
                    label="City"
                    placeholder="Enter city"
                    :error="$errors->first('city')"
                />

                <flux:input
                    wire:model="state"
                    label="State"
                    placeholder="Enter state"
                    :error="$errors->first('state')"
                />

                <flux:input
                    wire:model="pincode"
                    label="Pincode"
                    placeholder="Enter pincode"
                    :error="$errors->first('pincode')"
                />

            </div>

        </div>
    </div>

    {{-- Tax Information --}}
    <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

        <flux:heading size="lg">Tax Information</flux:heading>

        <div class="mt-6 grid gap-6 md:grid-cols-2">

            <flux:input
                wire:model="gstin"
                label="GSTIN"
                placeholder="Enter GSTIN"
            />

            <div class="flex items-center pt-7">
                <flux:checkbox
                    wire:model="is_active"
                    label="Active Customer"
                />
            </div>

        </div>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3">

        <flux:button
            href="{{ route('customers') }}"
            variant="ghost"
            wire:navigate
        >
            Cancel
        </flux:button>

        <flux:button variant="primary" wire:click="save">
            Save Customer
        </flux:button>

    </div>

</div>