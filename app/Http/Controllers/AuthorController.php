<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = DB::table('authors')
            ->where('user_id', auth()->id()) // ✅
            ->get();
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|min:2|max:255',
            'email'       => 'required|email|unique:authors',
            'books_count' => 'required|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        DB::table('authors')->insert([
            'id'          => (string) Str::uuid(),
            'user_id'     => (string) auth()->id(), // ✅
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'books_count' => $validated['books_count'],
            'status'      => $validated['status'],
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('authors.index')->with('success', 'Author created successfully');
    }

    public function show(string $id)
    {
        $author = DB::table('authors')
            ->where('id', $id)
            ->where('user_id', auth()->id()) // ✅
            ->first();
        return view('authors.show', compact('author'));
    }

    public function edit(string $id)
    {
        $author = DB::table('authors')
            ->where('id', $id)
            ->where('user_id', auth()->id()) // ✅
            ->first();
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|min:2|max:255',
            'email'       => 'required|email|unique:authors,email,' . $id,
            'books_count' => 'required|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        DB::table('authors')
            ->where('id', $id)
            ->where('user_id', auth()->id()) // ✅
            ->update([
                'name'        => $validated['name'],
                'email'       => $validated['email'],
                'books_count' => $validated['books_count'],
                'status'      => $validated['status'],
                'updated_at'  => now(),
            ]);

        return redirect()->route('authors.index')->with('success', 'Author updated successfully');
    }

    public function destroy(string $id)
    {
        DB::table('authors')
            ->where('id', $id)
            ->where('user_id', auth()->id()) // ✅
            ->delete();
        return redirect()->route('authors.index')->with('success', 'Author deleted successfully');
    }
}
