<?php

namespace Database\Seeders;

use App\Models\ImpoundSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImpoundSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*  // Create left slots (L1 to L12)
        for ($i = 1; $i <= 12; $i++) {
            ImpoundSlot::create(['slot_code' => "L{$i}", 'is_occupied' => false]);
        }

        // Create right slots (R1 to R12)
        for ($i = 1; $i <= 12; $i++) {
            ImpoundSlot::create(['slot_code' => "R{$i}", 'is_occupied' => false]);
        } */

        ImpoundSlot::factory(36)->create();
    }
}
