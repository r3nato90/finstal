<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::create([
           'name' => 'English',
           'code' => 'en',
           'is_default' => Status::ACTIVE->value
        ]);
    }
}
