<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BooksController extends Controller
{
    public function index()
    {
        $Books = DB::table('books')
            ->where('user_id', auth()->id()) // ✅
            ->get();
        return view('Books.index', compact('Books'));
    }

    public function create()
    {

        
        $authors    = DB::table('authors')
            ->where('user_id', auth()->id()) // ✅ only show user's own authors
            ->get();
        $categories = DB::table('categories')
            ->where('user_id', auth()->id()) // ✅ only show user's own categories
            ->get();

           
        return view('Books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|min:2|max:255',
            'author_id'   => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'isbn'        => 'required|string|unique:books',
            'description' => 'nullable|string',
            'status'      => 'required|in:available,borrowed,reserved',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->storeAs(
                'covers',
                $request->file('cover')->getClientOriginalName(),
                'public'
            );
        }

        DB::table('books')->insert([
            'id'          => (string) Str::uuid(),
            'user_id'     => (string) auth()->id(), 
            'title'       => $validated['title'],
            'author_id'   => $validated['author_id'],
            'category_id' => $validated['category_id'],
            'isbn'        => $validated['isbn'],
            'description' => $validated['description'] ?? null,
            'status'      => $validated['status'],
            'cover'       => $coverPath,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('Books.index')->with('success', 'Book created successfully');
    }

    public function show(string $id)
    {
        $book = DB::table('books')
            ->where('id', $id)
            ->where('user_id', auth()->id()) // ✅
            ->first();
        return view('Books.show', compact('book'));
    }

    public function edit(string $id)
    {
        $book = DB::table('books')
            ->where('id', $id)
            ->where('user_id', auth()->id()) // ✅
            ->first();
        $authors    = DB::table('authors')
            ->where('user_id', auth()->id()) // ✅
            ->get();
        $categories = DB::table('categories')
            ->where('user_id', auth()->id()) // ✅
            ->get();
            $statuses = [
                'available' => 'Available',
                'borrowed'  => 'Borrowed',
                'reserved'  => 'Reserved',
            ];
        
        return view('Books.edit', compact('book', 'authors', 'categories','statuses'));
    }

    public function update(Request $request, string $id)
    {
         
        //dd($request->all());

        $validated = $request->validate([
            'title'       => 'required|string|min:2|max:255',
            'author_id'   => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'isbn'        => 'required|string|unique:books,isbn,' . $id,
            'description' => 'nullable|string',
            'status'      => 'required|in:available,borrowed,reserved',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->storeAs(
                'covers',
                $request->file('cover')->getClientOriginalName(),
                'public'
            );
        }

        DB::table('books')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->update([
                'title'       => $validated['title'],
                'author_id'   => $validated['author_id'],
                'category_id' => $validated['category_id'],
                'isbn'        => $validated['isbn'],
                'description' => $validated['description'] ?? null,
                'status'      => $validated['status'],
                'cover'       => $coverPath,
                'updated_at'  => now(),
            ]);

        return redirect()->route('Books.index')->with('success', 'Book updated successfully');
    }

    public function destroy(string $id)
    {
        DB::table('books')
            ->where('id', $id)
            ->where('user_id', auth()->id()) 
            ->delete();
        return redirect()->route('Books.index')->with('success', 'Book deleted successfully');
    }
}
