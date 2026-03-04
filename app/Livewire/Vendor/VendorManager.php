<?php

namespace App\Livewire\Vendor;

use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Vendors')]
class VendorManager extends Component
{
    use WithPagination;

    public $vendorId;
    public $name;
    public $phone;
    public $address;
    public $is_active = true;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:50',
        'address' => 'nullable|string|max:255',
        'is_active' => 'required|boolean',
    ];

    public function render()
    {
        $vendors = Vendor::where('is_active', true)->orderBy('name')->paginate(10);

        return view('livewire.vendor.vendor-manager', [
            'vendors' => $vendors,
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->vendorId = null;
        $this->name = '';
        $this->phone = '';
        $this->address = '';
        $this->is_active = true;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        Vendor::updateOrCreate(['id' => $this->vendorId], [
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->vendorId ? 'Vendor updated successfully.' : 'Vendor created successfully.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);

        $this->vendorId = $vendor->id;
        $this->name = $vendor->name;
        $this->phone = $vendor->phone;
        $this->address = $vendor->address;
        $this->is_active = $vendor->is_active;

        $this->openModal();
    }

    public function delete($id)
    {
        Vendor::find($id)->delete();
        session()->flash('message', 'Vendor deleted successfully.');
    }
}
