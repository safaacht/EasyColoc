<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        
        // use the user's active colocation
        $colocation = auth()->user()->colocations()->wherePivot('status', 'joined')->wherePivot('type', 'owner')->first();
        
        if (!$colocation) {
             return redirect()->back()->with('error', 'You must own a colocation to create categories.');
        }

        Category::create([
            'name' => $validated['name'],
            'colocation_id' => $colocation->id,
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $colocation = auth()->user()->colocations()->wherePivot('type', 'owner')->first();
        
        if (!$colocation || $category->colocation_id !== $colocation->id) {
            abort(403);
        }

        $category->update($request->validated());
        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $colocation = auth()->user()->colocations()->wherePivot('type', 'owner')->first();
        
        if (!$colocation || $category->colocation_id !== $colocation->id) {
            abort(403);
        }

        // checking if category is used by any other expenses
        if ($category->expenses()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete category that has expenses.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
