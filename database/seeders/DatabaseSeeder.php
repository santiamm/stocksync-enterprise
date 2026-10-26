<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario de prueba solo para uso local (contraseña: password)
        User::factory()->create([
            'name' => 'Operario Demo',
            'email' => 'demo@stocksync.test',
        ]);

        $this->call([
            CategorySeeder::class,
            DemoSeeder::class,
        ]);
    }
}
