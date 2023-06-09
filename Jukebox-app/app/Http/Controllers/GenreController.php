<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $genres = Genre::orderBy('name')->get();
      return view('genre.index', ['genres' => $genres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $messages = [
        'required' => 'This field is required',
        'string' => 'This value must be a word',
      ];

      $request->validate([
        'name' => ['required', 'string'],
      ], $messages);

      Genre::create([
        "name" => $request['name'],
      ]);
      return redirect(route('genre.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
      return view('genre.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
      $messages = [
        'required' => 'This field is required',
        'string' => 'This value must be a word',
      ];

      $request->validate([
        'name' => ['required', 'string'],
      ], $messages);
      
      $genre->name = $request->input('name');
      $genre->save();
      return redirect(route('genre.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        //
    }
}
