<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vinilos = [
            ['name' => 'Santaflow - Red Vol. 1', 'price' => 24.99, 'description' => 'Doble vinilo con lo mejor del rap español intenso.'],
            ['name' => 'Persona 5 Royal OST', 'price' => 89.99, 'description' => 'Edición coleccionista 4LP en color rojo translúcido con la banda sonora original.'],
            ['name' => 'Grand Theft Auto V - The Score', 'price' => 34.50, 'description' => 'Música original del icónico videojuego de Los Santos en vinilo.'],
            ['name' => 'Dunkirk - Original Motion Picture Soundtrack', 'price' => 29.99, 'description' => 'Banda sonora original de Hans Zimmer que transmite pura tensión.'],
            ['name' => 'The Backrooms - Ambient Score', 'price' => 19.99, 'description' => 'Sonidos liminales y ambientales en edición de cera amarilla.'],
            ['name' => 'Daft Punk - Random Access Memories', 'price' => 39.99, 'description' => 'Clásico moderno de la electrónica.'],
            ['name' => 'Pink Floyd - The Dark Side of the Moon', 'price' => 32.00, 'description' => 'Edición remasterizada 180g.'],
            ['name' => 'Michael Jackson - Thriller', 'price' => 28.50, 'description' => 'El álbum más vendido de todos los tiempos.'],
            ['name' => 'AC/DC - Back in Black', 'price' => 26.90, 'description' => 'Puro rock en vinilo negro clásico.'],
            ['name' => 'Nirvana - Nevermind', 'price' => 27.00, 'description' => 'Sonido grunge de los 90s inigualable en formato analógico.'],
            ['name' => 'Rosalía - El Mal Querer', 'price' => 25.50, 'description' => 'Fusión y revolución musical contemporánea.'],
            ['name' => 'Eminem - The Eminem Show', 'price' => 31.00, 'description' => 'Doble LP con los grandes éxitos de la era dorada del rap.'],
        ];

        foreach ($vinilos as $vinilo) {
            Product::create($vinilo);
        }
    }
}
