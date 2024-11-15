<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'category_name' => 'روايات',
        ]);
        Category::create([
            'category_name' => 'كتب دينية',
        ]);
        Category::create([
            'category_name' => 'كتب الأدب',
        ]);
        Category::create([
            'category_name' => 'كتب تاريخية',
        ]);
        Category::create([
            'category_name' => 'كتب علمية',
        ]);
        Category::create([
            'category_name' => 'علم النفس وتطوير الذات',
        ]);
        Category::create([
            'category_name' => 'كتب بوليسية',
        ]);
        Category::create([
            'category_name' => 'فنون',
        ]);
        Category::create([
            'category_name' => 'كتب صوتية',
        ]);
        Category::create([
            'category_name' => 'ترفيهي أطفال',
        ]);
        Category::create([
            'category_name' => 'تعلمي أطفال',
        ]);
        Category::create([
            'category_name' => 'أغاني ترفيهية',
        ]);
        Category::create([
            'category_name' => 'أغاني تعليمة ',
        ]);
      
        



}}
