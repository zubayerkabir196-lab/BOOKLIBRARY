<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class categoriesController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')
        ->where('user_id', auth()->id())  // ✅ only get logged in user's categories
        ->get();
    
    return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name'        => 'required|string|min:2|max:255',
            'description' => 'nullable|string|min:10',
            'books_count' => 'required|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        DB::table('categories')->insert([
            'id'          => (string) Str::uuid(), // ✅ cast to string
            'user_id'     => (string) auth()->id(), // ✅ cast to string
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'books_count' => $validated['books_count'],
            'status'      => $validated['status'],
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function show(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        return view('categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = DB::table('categories')
        ->where('id', $id)
        ->where('user_id', auth()->id())  // ✅
        ->first();
    
    return view('categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|min:2|max:255',
            'description' => 'nullable|string|min:10',
            'books_count' => 'required|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        DB::table('categories')
        ->where('id', $id)
        ->where('user_id', auth()->id())->update([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'books_count' => $validated['books_count'],
            'status'      => $validated['status'],
            'updated_at'  => now(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(string $id)
    {
        DB::table('categories')
        ->where('id', $id)
        ->where('user_id', auth()->id())  // ✅
        ->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
