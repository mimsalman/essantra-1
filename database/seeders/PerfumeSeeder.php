<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perfume;

class PerfumeSeeder extends Seeder
{
    public function run(): void
    {
        $perfumes = [
            [
                'name' => 'Dior Sauvage',
                'brand' => 'Dior',
                'price' => 129.99,
                'stock' => 20,
                'description' => 'Fresh spicy fragrance with bergamot and ambroxan.',
            ],
            [
                'name' => 'Bleu de Chanel',
                'brand' => 'Chanel',
                'price' => 149.99,
                'stock' => 15,
                'description' => 'Woody aromatic fragrance with citrus and incense notes.',
            ],
            [
                'name' => 'Acqua di Gio',
                'brand' => 'Giorgio Armani',
                'price' => 99.99,
                'stock' => 25,
                'description' => 'Aquatic citrus fragrance inspired by the sea.',
            ],
            [
                'name' => 'Black Opium',
                'brand' => 'YSL',
                'price' => 119.99,
                'stock' => 18,
                'description' => 'Warm sweet fragrance with coffee and vanilla.',
            ],
        ];

        foreach ($perfumes as $p) {
            Perfume::create($p);
        }
    }
}
