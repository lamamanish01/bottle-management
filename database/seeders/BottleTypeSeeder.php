<?php

namespace Database\Seeders;

use App\Models\BottleType;
use Illuminate\Database\Seeder;

class BottleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'PET', 'unit' => 'kg'],
            ['name' => 'HDPE', 'unit' => 'kg'],
            ['name' => 'PP', 'unit' => 'kg'],
            ['name' => 'PVC', 'unit' => 'kg'],
            ['name' => 'LDPE', 'unit' => 'kg'],
        ];
        foreach ($types as $type) {
            BottleType::create($type);
        }
    }
}
