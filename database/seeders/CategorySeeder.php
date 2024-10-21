<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Create the main category 'framework'
        $framework = Category::create([
            'name' => 'Framework',
            'slug' => 'framework',
            'parent_id' => null,
        ]);

        // Create subcategories under 'framework'
        Category::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
            'parent_id' => $framework->id,
        ]);

        Category::create([
            'name' => 'CodeIgniter',
            'slug' => 'codeigniter',
            'parent_id' => $framework->id,
        ]);

        Category::create([
            'name' => 'Symfony',
            'slug' => 'symfony',
            'parent_id' => $framework->id,
        ]);
    }
}
