<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:show_products', ['only' => ['index']]);
        $this->middleware('permission:create_products', ['only' => ['store', 'create']]);
        $this->middleware('permission:edit_products', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_products', ['only' => ['destroy', 'massDeleteProducts']]);
    }
    public function index()  : View
    {
        $products = Product::with(['user', 'category'])->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $categories = Category::all();
        $users = User::all();
        return view('products.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();
        $product = Product::create($validatedData);

        if ($product) {
            return response()->json(['message' => "Product Created successfully", 'product' => $product]);
        } else {
            return response()->json(['message' => "Product Not Created successfully"], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)  : View
    {
        $categories = Category::all();
        $users = User::all();
        return view('products.create', compact('product', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product) 
    {
        $validatedData = $request->validated();

        if ($product->update($validatedData)) {
            return response()->json(['message' => "Product Updated successfully"]);
        } else {
            return response()->json(['message' => "Product Not Updated successfully"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->delete()) {
            return response()->json(['message' => "Product Deleted"], 200);
        } else {
            return response()->json(['message' => "Product Not Found"], 404);
        }
    }


    public function massDeleteProducts(Request $request)
    {
        $ids = $request->ids;
        Product::destroy($ids);

        return response()->json(['message' => "Deleted Successfully"]);
    }
}
