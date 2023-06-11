<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NonMedicalCategoryTableSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("non_medical_categories")->insert([
            ["category_name" => "Anne & Bebek"],
            ["category_name" => "Dermokozmetik"],
            ["category_name" => "Güneş Bakımı"],
            ["category_name" => "Besin Takviyesi"],
            ["category_name" => "Bağışıklık Güçlendirici"],
            ["category_name" => "Vitamin & Mineral"],
            ["category_name" => "Kişisel Bakım"],
            ["category_name" => "Medikal Ürünler"],
            ["category_name" => "Saç Bakımı"],
            ["category_name" => "Cinsel Sağlık"],
        ]);
    }
}
