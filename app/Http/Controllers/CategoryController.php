<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
    }

    public function store(Request $request)
    {
    }

    public function show(Category $category)
    {
    }

    public function edit(Category $category)
    {
    }

    public function update(Request $request, Category $category)
    {
    }

    public function destroy(Category $category)
    {
    }
}
