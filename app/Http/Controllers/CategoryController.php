<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()
            ->paginate(10);
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'parent_id' => $request->get('parent_id'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
    }

    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'parent_id' => $request->get('parent_id'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if (Post::where('category_id', $category->id)->exists()) {
            return redirect()->route('categories.index')->with('error', 'Category cannot be deleted because it is associated with existing posts.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
