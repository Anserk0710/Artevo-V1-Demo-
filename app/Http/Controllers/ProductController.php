<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Http\Resources\ProductResource;
use App\Helpers\ActivityLogger;

class ProductController extends Controller
{
    // Daftar aturan validasi yang digunakan untuk store dan update
    protected $validationRules = [
        'name' => 'required|string',
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'image' => 'nullable|string',
        'size' => 'nullable|string',
        'material' => 'nullable|string',
    ];

    // Daftar field produk yang sering digunakan
    protected $productFields = ['name', 'price', 'description', 'image', 'size', 'material'];

    public function index()
    {
        $products = Product::latest()->paginate(10);
        return Inertia::render('Admin/Products/Index', [
            'products' => ProductResource::collection($products)->response()->getData(true),
        ]);
    }
    
    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->validationRules);

        $originalData = $product->only($this->productFields);
        $product->update($validated);
        $updatedData = $product->only($this->productFields);

        $changes = [];
        foreach ($originalData as $field => $originalValue) {
            if ($originalValue != $updatedData[$field]) {
                $changes[] = ucfirst($field) . ": '$originalValue' => '{$updatedData[$field]}'";
            }
        }

        if (!empty($changes)) {
            $description = $this->getAdminName() . " mengupdate produk ID {$product->id} dengan perubahan: " . implode(', ', $changes) . ".";
            $this->logActivity('Mengupdate Produk', $description);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        $description = 'ID: ' . $product->id . ' - Nama: ' . $product->name;
        $this->logActivity('Menghapus Produk', $description);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);
        $product = Product::create($validated);

        $description = $this->getAdminName() . " menambahkan produk: Nama Produk: {$product->name}, Harga: {$product->price}, Ukuran: {$product->size}, Material: {$product->material}.";
        $this->logActivity('Menambah Produk', $description);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function showByCode($code)
    {
        $product = Product::where('product_code', $code)->firstOrFail();
        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

    // Mendapatkan nama admin yang sedang login
    private function getAdminName()
    {
        return auth()->user()->name ?? 'Admin';
    }

    // Fungsi untuk mencatat aktivitas dengan ActivityLogger
    private function logActivity($action, $description)
    {
        ActivityLogger::log($action, $description);
    }
}
