<div class="flex h-full w-full flex-1 flex-col gap-6">

    {{-- Page Header --}}
    <div>
        <flux:heading size="xl">Add Product / Service</flux:heading>

        <flux:text class="mt-2">
            Enter the product or service information.
        </flux:text>
    </div>

    {{-- Product Information --}}
    <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

        <flux:heading size="lg">Product / Service Information</flux:heading>

        <div class="mt-6 space-y-6">

            <div class="grid gap-6 md:grid-cols-2">

                <flux:input
                    wire:model="code"
                    label="Product / Service Code"
                    placeholder="e.g. CLEAR"
                />

                <flux:input
                    wire:model="name"
                    label="Product / Service Name"
                    placeholder="e.g. Meissa CLEAR"
                />

            </div>

            <flux:textarea
                wire:model="description"
                label="Description"
                placeholder="Enter a description of the product or service"
            />

            <flux:checkbox
                wire:model="is_active"
                label="Active Product / Service"
            />

        </div>

    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3">

        <flux:button
            href="{{ route('products') }}"
            variant="ghost"
            wire:navigate
        >
            Cancel
        </flux:button>

        <flux:button
            variant="primary"
            wire:click="save"
        >
            Save Product
        </flux:button>

    </div>

</div>