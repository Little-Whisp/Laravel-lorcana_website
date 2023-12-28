<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Display a listing of categories
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Show the form for creating a new category
    public function create()
    {
        return view('categories.create');
    }

    // Store a newly created category in the database
    public function store(Request $request)
    {
        // Validate and store category
        // Implement your validation logic based on your requirements
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable|max:255',
        ]);

        // Create a new category with the provided data
        Category::create($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    // Show the form for editing the specified category
    public function edit($id)
    {
        // Find the category by ID or throw a 404 error if not found
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // Update the specified category in the database
    public function update(Request $request, $id)
    {
        // Validate and update category
        // Implement your validation logic based on your requirements
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
        ]);

        // Find the category by ID or throw a 404 error if not found
        $category = Category::findOrFail($id);
        // Update the category with the provided data
        $category->update($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    // Remove the specified category from the database
    public function destroy($id)
    {
        // Find the category by ID or throw a 404 error if not found
        $category = Category::findOrFail($id);
        // Delete the category
        $category->delete();

        // Redirect to the index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
