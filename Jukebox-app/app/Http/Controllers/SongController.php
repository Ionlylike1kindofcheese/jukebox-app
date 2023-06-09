<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $selectedGenre = $request->input('genre');
      $query = Song::query();
      
      if ($selectedGenre) {
        $query->whereHas('genres', function ($query) use ($selectedGenre) {
          $query->where('genres.id', $selectedGenre);
        });
      }

      $songs = $query->get();
      $genres = Genre::all();
      
      return view('song.index', ['songs' => $songs, 'genres' => $genres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $genres = Genre::all();
      return view('song.create', ['genres' => $genres]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $messages = [
        'required' => 'This field is required',
        'date' => 'This value should be a date',
        'string' => 'This value must be a word',
        'integer' => 'This value must be a number',
        'before:now' => 'This date cannot be in the future',
        'array' => 'At least 1 genre is required',
      ];

      $request->validate([
        'name' => ['required', 'string'],
        'author' => ['required', 'string'],
        'album' => ['required', 'string'],
        'release' => ['required', 'date', 'before:now'],
        'duration' => ['required', 'integer'],
        'genre_id' => ['required', 'array'],
      ], $messages);

      $song = Song::create([
        "name" => $request['name'],
        "author" => $request['author'],
        "album" => $request['album'],
        "release" => $request['release'],
        "duration" => $request['duration'],
        "contributor" => auth()->user()->email,
      ]);

      $songId = $song->getAttribute('id');

      foreach ($request["genre_id"] as $genreId) {
        DB::table('genre_song')->insert([
          'song_id' => $songId,
          'genre_id' => $genreId,
        ]);
      }

      return redirect(route('song.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
      return view('song.view', ['song' => $song]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song)
    {
      DB::table('deleted_songs')->insert([
        'song_id' => $song->id,
        'name' => $song->name,
        'author' => $song->name,
        'release' => $song->release,
        'contributor' => $song->contributor,
      ]);

      $song->genres()->detach();
      Song::destroy($song->id);
      return redirect(route('song.index'));
    }
}
