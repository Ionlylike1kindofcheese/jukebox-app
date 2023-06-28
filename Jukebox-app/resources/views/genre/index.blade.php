@extends('layouts.master')

@section('mainContent')
  <h1>Dit is een totaaloverzicht van alle genres</h1>
  <ul>
  @foreach($genres as $genre)
    <li>
      @if(auth()->user()?->email == "admin@gmail.com")        
        <a href="{{route('genre.destroy', ['genre' => $genre->id])}}">X</a> 
      @endif
      {{$genre->name}}
    </li>
  @endforeach
  </ul>
  @if(auth()->user()?->email == "admin@gmail.com")  
    <a href="{{route('genre.create')}}">Genre Toevoegen</a>
  @endif
@endsection