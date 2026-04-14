<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = DB::table('categories')->get();
        return view('categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|min:2|max:255',
            'description' => 'required|string|min:10',
            'books_count'=>'required|integer|min:0',
            'status'=>'required|in:active,inactive',

        ]);
        DB::table('categories')->insert([
            'name'=>$validated['name'],
            'description'=>$validated['description'],
            'books_count'=>$validated['books_count'],
            'status'=>$validated['status'],
            'user_id'=> auth()->id(),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        
        return redirect()->route('categories.index')->with('success','categories created successfully');
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
        $category =DB::table('categories')->find($id);
        return view('categories.edit',compact('category'));
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
        DB::table('categories')->where('id',$id)->update([
            'name'=>$validated['name'],
            'description'=>$validated['description'],
            'books_count'=>$validated['books_count'],
            'status'=>$validated['status'],
           
            'updated_at'=>now(),
        ]);
        return redirect()->route('categories.index')->with('success','categories  updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('categories')->where('id',$id)->delete();
        return redirect()->route('categories.index')->with('success','categories deleted successfully');
    }
}
