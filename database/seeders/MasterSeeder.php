<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // Isi 4 Data Kategori Kaos
        Category::create(['nama_category' => 'Kaos Polos']);
        Category::create(['nama_category' => 'Kaos Oversize']);
        Category::create(['nama_category' => 'Kaos Raglan']);
        Category::create(['nama_category' => 'Polo Shirt']);

        // Isi 4 Data Brand Kaos
        Brand::create(['nama_brand' => 'Gildan']);
        Brand::create(['nama_brand' => 'Uniqlo']);
        Brand::create(['nama_brand' => 'New States Apparel']);
        Brand::create(['nama_brand' => 'H&M']);
    }
}
