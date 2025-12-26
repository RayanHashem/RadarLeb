<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Game::insert([
            ['name'=>'Mobile','price'=>1500,'image_path'=>'assets/leb-2.png'],
            ['name'=>'Bike electronics','price'=>15000,'image_path'=>'assets/winners.svg'],
            ['name'=>'SUV','price'=>50000,'image_path'=>'assets/winners.svg'],
            ['name'=>'muscle car','price'=>150000,'image_path'=>'assets/winners.svg'],
            ['name'=>'Cash','price'=>200000,'image_path'=>'assets/winners.svg'],

        ]);
    }
}
