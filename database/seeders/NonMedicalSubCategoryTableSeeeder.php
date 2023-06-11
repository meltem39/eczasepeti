<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NonMedicalSubCategoryTableSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("non_medical_sub_categories")->insert([
            [
                "category_id" => 1,
                "sub_category_name" => "Bebek Bakımı"
            ],[
                "category_id" => 1,
                "sub_category_name" => "Anne Bakımı"
            ],[
                "category_id" => 1,
                "sub_category_name" => "Beslenme Gereçleri"
            ],[
                "category_id" => 1,
                "sub_category_name" => "Diğer Anne & Bebek"
            ],
            [
                "category_id" => 2,
                "sub_category_name" => "Temizleyici & Maske"
            ],[
                "category_id" => 2,
                "sub_category_name" => "Nemlendirici"
            ],[
                "category_id" => 2,
                "sub_category_name" => "Cilt Serumu"
            ],[
                "category_id" => 2,
                "sub_category_name" => "Aromatik Yağlar"
            ],[
                "category_id" => 2,
                "sub_category_name" => "Göz & Dudak Bakımı"
            ],[
                "category_id" => 2,
                "sub_category_name" => "Renkli Kozmetik"
            ],[
                "category_id" => 2,
                "sub_category_name" => "Diğer Cilt Bakımı"
            ],
            [
                "category_id" => 3,
                "sub_category_name" => "Güneş Bakımı"
            ],
            [
                "category_id" => 4,
                "sub_category_name" => "Probiyotik/Prebiyotik"
            ],[
                "category_id" => 4,
                "sub_category_name" => "Kolajen"
            ],[
                "category_id" => 4,
                "sub_category_name" => "Pastil"
            ],[
                "category_id" => 4,
                "sub_category_name" => "Diğer Besin Takviyesi"
            ],
            [
                "category_id" => 5,
                "sub_category_name" => "Bağışıklık Güçlendirici"
            ],
            [
                "category_id" => 6,
                "sub_category_name" => "Vitamin"
            ],[
                "category_id" => 4,
                "sub_category_name" => "Mineral"
            ],[
                "category_id" => 6,
                "sub_category_name" => "Multivitamin"
            ],[
                "category_id" => 6,
                "sub_category_name" => "Omega 3 & Balık Yağı"
            ],
            [
                "category_id" => 7,
                "sub_category_name" => "Vücut Bakımı"
            ],[
                "category_id" => 7,
                "sub_category_name" => "Ağız Bakım Ürünleri"
            ],[
                "category_id" => 7,
                "sub_category_name" => "Göz Sağlığı & Optik"
            ],[
                "category_id" => 7,
                "sub_category_name" => "Kadın Hijyen Ürünleri"
            ],[
                "category_id" => 7,
                "sub_category_name" => "Deodorant & Parfüm"
            ],[
                "category_id" => 7,
                "sub_category_name" => "El & Ayak Bakımı"
            ],[
                "category_id" => 7,
                "sub_category_name" => "Günlük Bakım"
            ],[
                "category_id" => 7,
                "sub_category_name" => "Diğer Bakım Ürünleri"
            ],
            [
                "category_id" => 8,
                "sub_category_name" => "Maske & Eldiven"
            ],[
                "category_id" => 8,
                "sub_category_name" => "Dezenfektan"
            ],[
                "category_id" => 8,
                "sub_category_name" => "Kolonya"
            ],[
                "category_id" => 8,
                "sub_category_name" => "Boğaz & Burun Spreyleri"
            ],[
                "category_id" => 8,
                "sub_category_name" => "Yara Bakım Ürünleri"
            ],[
                "category_id" => 8,
                "sub_category_name" => "Hasta Bakımı"
            ],[
                "category_id" => 8,
                "sub_category_name" => "Medikal Cihazlar"
            ],[
                "category_id" => 8,
                "sub_category_name" => "Kulak Tıkayıcı"
            ],[
                "category_id" => 8,
                "sub_category_name" => "Diğer Medikal Ürünler"
            ],
            [
                "category_id" => 9,
                "sub_category_name" => "Şampuan"
            ],[
                "category_id" => 9,
                "sub_category_name" => "Saç Kremi"
            ],[
                "category_id" => 9,
                "sub_category_name" => "Saç Serumu"
            ],[
                "category_id" => 9,
                "sub_category_name" => "Saç Bakım Yağı"
            ],[
                "category_id" => 9,
                "sub_category_name" => "Saç Boyası"
            ],[
                "category_id" => 9,
                "sub_category_name" => "Saç Maskesi"
            ],[
                "category_id" => 9,
                "sub_category_name" => "Saç Fırçası"
            ],[
                "category_id" => 9,
                "sub_category_name" => "Saç Şekillendirici"
            ],[
                "category_id" => 9,
                "sub_category_name" => "Diğer Saç Bakımı"
            ],
            [
                "category_id" => 10,
                "sub_category_name" => "Gebelik Testi"
            ],[
                "category_id" => 10,
                "sub_category_name" => "Prezervatif"
            ],[
                "category_id" => 10,
                "sub_category_name" => "Kayganlaştırıcı & Masaj Jeli"
            ],
        ]);

    }
}
