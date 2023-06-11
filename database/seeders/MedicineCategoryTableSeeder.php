<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("medicine_categories")->insert([
            ["category_name" => "Anabolik steroidler"],
            ["category_name" => "Analjezikler"],
            ["category_name" => "Anestezikler"],
            ["category_name" => "Antianjinal ilaçlar"],
            ["category_name" => "Antidemans ajanlar"],
            ["category_name" => "Antidiyabetikler"],
            ["category_name" => "Antiemetikler"],
            ["category_name" => "Antienfeksiyon ajanlar"],
            ["category_name" => "Antienflamatuar ajanlar"],
            ["category_name" => "Antihipertansif ilaçlar"],
            ["category_name" => "Antikonvülzanlar"],
            ["category_name" => "Antipiretikler"],
            ["category_name" => "Antiseptikler"],
            ["category_name" => "Antitrombotik ilaçlar"],
            ["category_name" => "Antitussif ve ekspektoranlar"],
            ["category_name" => "Antrakinon ilaçlar"],
            ["category_name" => "Atipik antipsikotikler"],
            ["category_name" => "Barbitüratlar"],
            ["category_name" => "Dekonjestanlar"],
            ["category_name" => "Hemostatik ajanlar"],
            ["category_name" => "Hipolipidemik ilaçlar"],
            ["category_name" => "Hormonal ajanlar"],
            ["category_name" => "Kas gevşeticiler"],
            ["category_name" => "Kemoterapik ajanlar"],
            ["category_name" => "Kortikosteroid ilaçlar"],
            ["category_name" => "Mide asiditesini azaltan ilaçlar"],
            ["category_name" => "Psikoaktif ilaçlar"],
            ["category_name" => "Psikoanaleptikler"],
            ["category_name" => "Seksüel disfonksiyon ilaçları"],
            ["category_name" => "Sempatomimetik aminler"]
        ]);

    }
}


