<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
    //TODO: add filter by category
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();
            if ($products == []) {
                return $this->notFound('there is no products');
            }

            return $this->success('got all products successfully', ProductResource::collection($products));
        } catch (\Throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validated([
                'name' => 'required',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'image' => ['file', 'mimetypes:image/*'],
            ]);
            $product = Product::create($data);

            if ($request->file('image')) {
                $path = $request->file('image')->storeAs('product', $product->id.'.'.$request->file('image')->extension(), 'custom');
                $product->update(['image' => $path]);
            }

            return $this->success('created product successfully', new ProductResource($product));
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            return $this->success('got product successfully', new ProductResource($product));
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $data = $request->validated([
                'name' => 'string',
                'price' => 'numeric',
                'quantity' => 'numeric',
                'category_id' => 'exists:categories,id',
                'image' => ['file', 'mimetypes:image/*'],
            ]);

            $product->update($data);

            if ($request->file('image')) {
                Storage::delete($product->image);
                $path = $request->file('image')->storeAs('product', $product->id.'.'.$request->file('image')->extension(), 'custom');
                $product->update(['image' => $path]);
            }

            return $this->success('updated product successfully', new ProductResource($product));
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            Storage::delete($product->image);
            $product->delete();

            return $this->success('deleted product successfully');
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }
}
