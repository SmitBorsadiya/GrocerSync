<div>
    <div class="mb-4 flex items-center justify-between">
        <flux:heading size="xl" level="1">{{ __('Products') }}</flux:heading>

        <flux:button wire:click="create" icon="plus" variant="primary">
            {{ __('Add Product') }}
        </flux:button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4">
            <flux:badge color="green" icon="check-circle">{{ session('message') }}</flux:badge>
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-900 shadow-sm border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
        <div class="mb-4 flex items-center gap-3">
            <div class="w-64">
                <flux:input wire:model.live.debounce.300ms="productSearch" placeholder="{{ __('Search products...') }}" />
            </div>
            <div class="w-64">
                <select wire:model.live="vendorFilter"
                    class="w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option value="">{{ __('All Vendors') }}</option>

                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}">
                            {{ $vendor->name }}
                        </option>
                    @endforeach

                </select>
            </div>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Vendor') }}</flux:table.column>
                <flux:table.column>{{ __('Price') }}</flux:table.column>
                <flux:table.column>{{ __('Quantity') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column>{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($products as $product)
                    <flux:table.row :key="$product->id">
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar size="sm" :name="$product->name" />
                                <div>
                                    <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $product->name }}</span>
                                    @if($product->unit)
                                        <div class="text-xs text-zinc-500">{{ $product->unit }}</div>
                                    @endif
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $product->vendor->name ?? 'N/A' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            ${{ number_format($product->price, 2) }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex items-center gap-2">
                                <span>{{ $product->quantity }}</span>
                                @if($product->quantity <= $product->threshold_qty)
                                    <flux:badge color="red" size="sm" icon="exclamation-triangle">Low Stock</flux:badge>
                                @endif
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($product->is_active)
                                <flux:badge color="green" size="sm">Active</flux:badge>
                            @else
                                <flux:badge color="zinc" size="sm">Inactive</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />

                                <flux:menu>
                                    <flux:menu.item wire:click="edit({{ $product->id }})" icon="pencil-square">
                                        {{ __('Edit') }}
                                    </flux:menu.item>
                                    <flux:menu.item wire:click="delete({{ $product->id }})"
                                        wire:confirm="Are you sure you want to delete this product?" icon="trash"
                                        variant="danger">{{ __('Delete') }}</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center py-4 text-zinc-500">
                            {{ __('No products found.') }}
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Create / Edit Modal -->
    <flux:modal wire:model="isModalOpen" name="product-modal"
        :heading="$productId ? __('Edit Product') : __('Create Product')">
        <form wire:submit.prevent="save" class="space-y-6">
            <flux:field>
                <flux:label>{{ __('Vendor') }}</flux:label>
                <select wire:model.live="vendor_id"
                    class="w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">{{ __('Select Vendor') }}</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
                <flux:error name="vendor_id" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Product Name') }}</flux:label>
                <flux:input wire:model.live="name" required />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Description') }}</flux:label>
                <flux:textarea wire:model.live="description" rows="3" />
                <flux:error name="description" />
            </flux:field>

            <div class="grid grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>{{ __('Price') }}</flux:label>
                    <flux:input wire:model.live="price" type="number" step="0.01" min="0" required />
                    <flux:error name="price" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Unit') }}</flux:label>
                    <flux:input wire:model.live="unit" placeholder="e.g., kg, pcs" />
                    <flux:error name="unit" />
                </flux:field>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>{{ __('Quantity') }}</flux:label>
                    <flux:input wire:model.live="quantity" type="number" min="0" required />
                    <flux:error name="quantity" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Low Stock Threshold') }}</flux:label>
                    <flux:input wire:model.live="threshold_qty" type="number" min="0" required />
                    <flux:error name="threshold_qty" />
                </flux:field>
            </div>

            <flux:checkbox wire:model.live="is_active" :label="__('Active')" />

            <div class="flex justify-end gap-3 pt-4">
                <flux:button wire:click="closeModal" variant="subtle">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>