@extends('layouts.master')

@section('mainContent')
  <form method="POST" action="{{route('playlist.store')}}">
    @csrf
    <label>Vul een naam in voor een playlist</label>
    <input name="playlistName" type="text"></input>
    <input type="submit" value="Bevestig"></input>
  </form>
@endsection