<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Books = DB::table('Books')->get();
        return view('Books.index',compact('Books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
        public function create()
        {
            $authors    = DB::table('authors')->get();
            $categories = DB::table('categories')->get();
            return view('Books.create', compact('authors', 'categories'));
        }
            

    /**
     * Store a newly created resource in storage.
     */
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
            'title'       => $validated['title'],
            'author_id'   => $validated['author_id'],
            'category_id' => $validated['category_id'],
            'isbn'        => $validated['isbn'],
            'description' => $request->description,
            'status'      => $validated['status'],
            'cover'       => $coverPath,
            'user_id'     => auth()->id(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    
        return redirect()->route('Books.index')->with('success', 'Book created successfully');
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
    public function edit(string $id)
    {
        $category =DB::table('Books')->find($id);
        return view('Books.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'=>'required|string|min:2|max:255',
            'description' => 'required|string|min:10',
            'books_count'=>'required|integer|min:0',
            'status'=>'required|in:active,inactive',
        ]);
        DB::table('Books')->where('id',$id)->update([
            'name'=>$validated['name'],
            'description'=>$validated['description'],
            'books_count'=>$validated['books_count'],
            'status'=>$validated['status'],
           
            'updated_at'=>now(),
        ]);
        return redirect()->route('Books.index')->with('success','Books  updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('Books')->where('id',$id)->delete();
        return redirect()->route('Books.index')->with('success','Books deleted successfully');
    }
}
