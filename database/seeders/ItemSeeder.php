<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::insert([
            ['code' => 'ITM-001', 'name' => 'Keyboard', 'price' => 200000],
            ['code' => 'ITM-002', 'name' => 'Mouse', 'price' => 400000],
            ['code' => 'ITM-003', 'name' => 'Monitor', 'price' => 1000000],
        ]);
    }
}
