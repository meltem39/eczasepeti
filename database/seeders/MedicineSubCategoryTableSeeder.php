<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("medicine_sub_categories")->insert([
            [
                "category_id" => 1,     //Anabolik steroidler
                "sub_category_name" => "Testosteron",
            ],
            [
                "category_id" => 2,      //Analjezikler
                "sub_category_name" => "Antimigren ilaçlar",
            ], [
                "category_id" => 2,
                "sub_category_name" => "Analjezikler",
            ], [
                "category_id" => 2,
                "sub_category_name" => "Asetilsalisilik asit",
            ], [
                "category_id" => 2,
                "sub_category_name" => "Opioidler"
            ],
            [
                "category_id" => 3,     //Anestezikler
                "sub_category_name" => "Genel Anestezikler"
            ], [
                "category_id" => 3,
                "sub_category_name" => "Lokal Anestezikler"
            ],
            [
                "category_id" => 4,     //Antianjinal ilaçlar
                "sub_category_name" => "Antianjinal"
            ],
            [
                "category_id" => 5,     //Antidemans ajanlar
                "sub_category_name" => "Antidemans ajanlar"
            ],
            [
                "category_id" => 6,     //Antidiyabetikler
                "sub_category_name" => "Alfa-glukozidaz inhibitörleri"
            ], [
                "category_id" => 6,
                "sub_category_name" => "Sülfonilüreler"
            ], [
                "category_id" => 6,
                "sub_category_name" => "Tiyazolidindionlar"
            ],
            [
                "category_id" => 7,     //Antiemetikler
                "sub_category_name" => "5-HT3 antagonistleri"
            ], [
                "category_id" => 7,
                "sub_category_name" => "Antiemetik"
            ],
            [
                "category_id" => 8,     //Antienfeksiyon ajanlar
                "sub_category_name" => "Antibiyotikler"
            ], [
                "category_id" => 8,
                "sub_category_name" => "Antifungal ilaçlar"
            ], [
                "category_id" => 8,
                "sub_category_name" => "Antiparazitik ajanlar"
            ], [
                "category_id" => 8,
                "sub_category_name" => "Antiviraller"
            ],
            [
                "category_id" => 9,     //Antienflamatuar ajanlar
                "sub_category_name" => "Glükokortikoidler"
            ], [
                "category_id" => 9,
                "sub_category_name" => "Non steroidal antienflamatuar ilaçlar"
            ],
            [
                "category_id" => 10,    //Antihipertansif ilaçlar
                "sub_category_name" => "Beta blokörler"
            ], [
                "category_id" => 10,
                "sub_category_name" => "Diüretikler"
            ], [
                "category_id" => 10,
                "sub_category_name" => "Kalsiyum kanal blokörleri"
            ], [
                "category_id" => 10,
                "sub_category_name" => "Vazodilatörler"
            ],
            [
                "category_id" => 11,     //Antikonvülzanlar
                "sub_category_name" => "Barbitüratlar"
            ], [
                "category_id" => 11,
                "sub_category_name" => "Benzodiazepinler"
            ],
            [
                "category_id" => 12,    //Antipiretikler
                "sub_category_name" => "Antipiretikler"
            ],
            [
                "category_id" => 13,    //Antiseptikler
                "sub_category_name" => "Antiseptikler"
            ],
            [
                "category_id" => 14,    //Antitrombotik ilaçlar
                "sub_category_name" => "Antikoagülanlar"
            ],
            [
                "category_id" => 14,
                "sub_category_name" => "Diğer platelet agregasyon inhibitörleri"
            ],
            [
                "category_id" => 15,    //Antitussif ve ekspektoranlar
                "sub_category_name" => "Antitussif ve ekspektoranlar"
            ],
            [
                "category_id" => 16,    //Antrakinon ilaçlar
                "sub_category_name" => "Antrasiklinler"
            ],
            [
                "category_id" => 17,    //Atipik antipsikotikler
                "sub_category_name" => "Atipik antipsikotik"
            ],
            [
                "category_id" => 18,    //Barbitüratlar
                "sub_category_name" => "Barbitürat"
            ],
            [
                "category_id" => 19,    //Dekonjestanlar
                "sub_category_name" => "Dekonjestan"
            ],
            [
                "category_id" => 20,    //Hemostatik ajanlar
                "sub_category_name" => "Hemostatik ajan"
            ],
            [
                "category_id" => 21,    //Hipolipidemik ilaçlar
                "sub_category_name" => "Hipolipidemikler"
            ],[
                "category_id" => 21,
                "sub_category_name" => "Statinler"
            ],
            [
                "category_id" => 22,    //Hormonal ajanlar
                "sub_category_name" => "Antiandrojenler"
            ], [
                "category_id" => 22,
                "sub_category_name" => "Antiglükokortikoidler"
            ],[
                "category_id" => 22,
                "sub_category_name" => "Antiprogesteron ajanlar"
            ],[
                "category_id" => 22,
                "sub_category_name" => "Aromataz inhibitörleri"
            ],[
                "category_id" => 22,
                "sub_category_name" => "Kortikosteroid ilaçlar"
            ],[
                "category_id" => 22,
                "sub_category_name" => "Selektif östrojen reseptör modülatörleri"
            ],[
                "category_id" => 22,
                "sub_category_name" => "Sentetik östrojenler"
            ],
            [
                "category_id" => 23,    // Kas gevşeticiler
                "sub_category_name" => "Kas gevşetici"
            ], [
                "category_id" => 23,
                "sub_category_name" => "Benzodiazepinler"
            ],
            [
                "category_id" => 24,    // Kemoterapik ajanlar
                "sub_category_name" => "Kemoterapik ajan"
            ], [
                "category_id" => 24,
                "sub_category_name" => "Antrasiklinler"
            ],
            [
                "category_id" => 25,    //Kortikosteroid ilaçlar
                "sub_category_name" => "Kortikosteroid"
            ], [
                "category_id" => 25,
                "sub_category_name" => "Glükokortikoidler"
            ],
            [
                "category_id" => 26,    //Mide asiditesini azaltan ilaçlar
                "sub_category_name" => "Antiasitler"
            ], [
                "category_id" => 26,
                "sub_category_name" => "H2-reseptör antagonistleri"
            ], [
                "category_id" => 26,
                "sub_category_name" => "Prostaglandinler"
            ], [
                "category_id" => 26,
                "sub_category_name" => "Proton pompa inhibitörleri"
            ],
            [
                "category_id" => 27,    //Psikoaktif ilaçlar
                "sub_category_name" => "Psikotrop madde"
            ],[
                "category_id" => 27,
                "sub_category_name" => "Psikofarmakoloji(Atipik antipsikotikler)"
            ],[
                "category_id" => 27,
                "sub_category_name" => "Psikofarmakoloji(Duygudurum dengeleyiciler)"
            ],[
                "category_id" => 27,
                "sub_category_name" => "Anksiyolitikler"
            ],[
                "category_id" => 27,
                "sub_category_name" => "Barbitüratlar"
            ],[
                "category_id" => 27,
                "sub_category_name" => "Benzodiazepinler"
            ],[
                "category_id" => 27,
                "sub_category_name" => "Antidepresanlar"
            ],[
                "category_id" => 27,
                "sub_category_name" => "Fenotiyazinler"
            ],[
                "category_id" => 27,
                "sub_category_name" => "Tipik antipsikotikler"
            ],[
                "category_id" => 27,
                "sub_category_name" => "Fenetilaminler"
            ],
            [
                "category_id" => 28,    //Psikoanaleptikler
                "sub_category_name" => "Antidemans ajanlar"
            ], [
                "category_id" => 28,
                "sub_category_name" => "Nootropikler"
            ],
            [
                "category_id" => 29,    //Seksüel disfonksiyon ilaçları
                "sub_category_name" => "Seksüel disfonksiyonlar"
            ],[
                "category_id" => 30,    //Sempatomimetik aminler
                "sub_category_name" => "Alfa adrenerjik agonistler"
            ],[
                "category_id" => 30,
                "sub_category_name" => "Amfetaminler"
            ],
        ]);
    }
}
