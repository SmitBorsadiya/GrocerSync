<div>
    <div class="mb-4 flex items-center justify-between">
        <flux:heading size="xl" level="1">{{ __('Vendors') }}</flux:heading>

        <flux:button wire:click="create" icon="plus" variant="primary">
            {{ __('Add Vendor') }}
        </flux:button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4">
            <flux:badge color="green" icon="check-circle">{{ session('message') }}</flux:badge>
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-900 shadow-sm border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Phone') }}</flux:table.column>
                <flux:table.column>{{ __('Address') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column>{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($vendors as $vendor)
                    <flux:table.row :key="$vendor->id">
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar size="sm" :name="$vendor->name" />
                                <div>
                                    <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $vendor->name }}</span>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $vendor->phone }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $vendor->address }}
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($vendor->is_active)
                                <flux:badge color="green" size="sm">Active</flux:badge>
                            @else
                                <flux:badge color="zinc" size="sm">Inactive</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />

                                <flux:menu>
                                    <flux:menu.item wire:click="edit({{ $vendor->id }})" icon="pencil-square">
                                        {{ __('Edit') }}
                                    </flux:menu.item>
                                    <flux:menu.item wire:click="delete({{ $vendor->id }})"
                                        wire:confirm="Are you sure you want to delete this vendor?" icon="trash"
                                        variant="danger">{{ __('Delete') }}</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center py-4 text-zinc-500">
                            {{ __('No vendors found.') }}
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($vendors->hasPages())
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $vendors->links() }}
            </div>
        @endif
    </div>

    <!-- Create / Edit Modal -->
    <flux:modal wire:model="isModalOpen" name="vendor-modal" :heading="$vendorId ? __('Edit Vendor') : __('Create Vendor')">
        <form wire:submit="save" class="space-y-6">
            <flux:field>
                <flux:label>{{ __('Vendor Name') }}</flux:label>
                <flux:input wire:model.live="name" required />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Phone') }}</flux:label>
                <flux:input wire:model.live="phone" required />
                <flux:error name="phone" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Address') }}</flux:label>
                <flux:textarea wire:model.live="address" rows="3" />
                <flux:error name="address" />
            </flux:field>

            <flux:checkbox wire:model.live="is_active" :label="__('Active')" />

            <div class="flex justify-end gap-3 pt-4">
                <flux:button wire:click="closeModal" variant="subtle">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>