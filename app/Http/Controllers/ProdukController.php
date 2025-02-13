<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\ProdukResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Product::all();
        return ResponseHelper::success('List produk', $produk);
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'criteria' => 'nullable|string',
            'favorite' => 'nullable|boolean',
            'status' => 'nullable|string',
            'stock' => 'nullable|integer',
        ]);
        $produk = Product::create($request->all());
        return ResponseHelper::success('produk berhasil ditambahkan', $produk);
    }
    public function destroy($id)
    {
        $produk = Product::find($id);

        if (!$produk) {
            return ResponseHelper::error('produk tidak ditemukan', 404);
        }

        $produk->delete();

        return ResponseHelper::success('produk berhasil di hapus');
    }
    public function show(Product $produk)
    {
        return ResponseHelper::success('detail produk', $produk);
    }
    public function update(Request $request, $id)
    {
        $produk = Product::find($id);

        if (!$produk) {
            return (new ResponseHelper)->error('Produk tidak ditemukan', [], 404);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'criteria' => 'nullable|string',
            'favorite' => 'nullable|boolean',
            'status' => 'nullable|string',
            'stock' => 'nullable|integer',
        ]);

        $produk->update($request->all());

        return (new ResponseHelper)->success('Product updated successfully', $produk);
    }
}
