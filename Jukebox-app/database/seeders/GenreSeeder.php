<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $genres = [
      ['name' => 'Rock'],
      ['name' => 'Metal'],
      ['name' => 'Pop'],
      ['name' => 'House'],
      ['name' => 'Explicit'],
      ['name' => 'Indie'],
    ];
    Genre::insert($genres);
  }
}