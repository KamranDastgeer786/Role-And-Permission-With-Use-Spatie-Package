<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:show_categories', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_categories', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_categories', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_categories', ['only' => ['destroy' , 'massDeleteCategoies']]);
    }
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
    
        $validatedData = $request->validated();
        $category = Category::create($validatedData);

        if ($category) {
            return response()->json(['message' => "Category Created successfully", 'category' => $category]);
        } else {
            return response()->json(['message' => "Category Not Created successfully"], 500);
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
    public function edit(Category $category)
    {
        if ($category) {
            return view('category.create', ['category' => $category]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validated();

        if ($category->update($validatedData)) {
            return response()->json(['message' => "Category Updated successfully"]);
        } else {
            return response()->json(['message' => "Category Not Updated successfully"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category) {
            if ($category->delete()) {
                return response()->json(['message' => "Category Deleted"], 200);
            }
        }
        return response()->json(['message' => "Category Not Found"], 404);
    }

    public function massDeleteCategoies(Request $request)
    {
        $ids = $request->ids;
        Category::destroy($ids);

        return response()->json(['message' => "Deleted Successfully"]);
    }
}
