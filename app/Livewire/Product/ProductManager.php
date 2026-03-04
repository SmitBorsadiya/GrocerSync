<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Vendor;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Products')]
class ProductManager extends Component
{
    use WithPagination;

    public $productId;
    public $vendor_id;
    public $name;
    public $description;
    public $price;
    public $unit;
    public $quantity = 0;
    public $threshold_qty = 0;
    public $is_active = true;
    public $isModalOpen = false;

    protected $rules = [
        'vendor_id' => 'required|exists:vendors,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'unit' => 'nullable|string|max:50',
        'quantity' => 'required|integer|min:0',
        'threshold_qty' => 'required|integer|min:0',
        'is_active' => 'required|boolean',
    ];

    protected $messages = [
        'vendor_id.required' => 'Please select a vendor.',
        'vendor_id.exists' => 'The selected vendor is invalid.',
    ];

    public function render()
    {
        $products = Product::with('vendor')->latest()->paginate(10);
        $vendors = Vendor::where('is_active', true)->orderBy('name')->get();

        return view('livewire.product.product-manager', [
            'products' => $products,
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
        $this->productId = null;
        $this->vendor_id = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->unit = '';
        $this->quantity = 0;
        $this->threshold_qty = 0;
        $this->is_active = true;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        Product::updateOrCreate(['id' => $this->productId], [
            'vendor_id' => $this->vendor_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'unit' => $this->unit,
            'quantity' => $this->quantity,
            'threshold_qty' => $this->threshold_qty,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->productId ? 'Product updated successfully.' : 'Product created successfully.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->productId = $product->id;
        $this->vendor_id = $product->vendor_id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->unit = $product->unit;
        $this->quantity = $product->quantity;
        $this->threshold_qty = $product->threshold_qty;
        $this->is_active = $product->is_active;

        $this->openModal();
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            session()->flash('message', 'Product deleted successfully.');
        }
    }
}
