<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = DB::table('authors')->get();
        return view('authors.index',compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'=>'required|integer|unique:authors',
            'name'=>'required|string|min:2|max:255',
            'email'=>'required|email|unique:authors',
            'books_count'=>'required|integer|min:0',
            'status'=>'required|in:active,inactive',
            'created_at'=>'required|date',
            'updated_at'=>'required|date',

        ]);
        DB::table('authors')->insert([
            'name'=>$validated['name'],
            'email'=>$validated['email'],
            'books_count'=>$validated['books_count'],
            'status'=>$validated['status'],
            'created_at'=>$validated['created_at'],
            'updated_at'=>$validated['updated_at'],
        ]);
        return redirect()->route('authors.index')->with('success','Author created successfully');
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
        $author =DB::table('authors')->find($id);
        return view('authors.edit',compact('authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'=>'required|string|min:2|max:255',
            'email'=>'required|email|unique:authors,email,'.$id,
            'books_count'=>'required|integer|min:0',
            'status'=>'required|in:active,inactive',
            'created_at'=>'required|date',
            'updated_at'=>'required|date',

        ]);
        DB::table('authors')->where('id',$id)->update([
            'name'=>$validated['name'],
            'email'=>$validated['email'],
            'books_count'=>$validated['books_count'],
            'status'=>$validated['status'],
            'created_at'=>$validated['created_at'],
            'updated_at'=>$validated['updated_at'],
        ]);
        return redirect()->route('authors.index')->with('success','Author updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('authors')->where('id',$id)->delete();
        return redirect()->route('authors.index')->with('success','Author deleted successfully');
    }
}
