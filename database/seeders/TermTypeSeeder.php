<?php

namespace Database\Seeders;

use App\Models\TermType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TermType::insert([
            ['name' => TermType::SCIENTIFIC_TERMS],
            ['name' => TermType::EXPERT_COMMENTS],
        ]);
    }
}
