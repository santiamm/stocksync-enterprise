<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electrónica', 'description' => 'Dispositivos y repuestos'],
            ['name' => 'Ferretería', 'description' => 'Herramientas y materiales de construcción'],
            ['name' => 'Textiles', 'description' => 'Ropa y dotación industrial'],
            ['name' => 'Insumos Médicos', 'description' => 'Material estéril y equipos'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}