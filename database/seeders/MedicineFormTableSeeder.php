<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MedicineFormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("medicine_forms")->insert([
            ["form_name" => "Tablet"],
            ["form_name" => "Kapsül"],
            ["form_name" => "Draje"],
            ["form_name" => "Süspansiyon"],
            ["form_name" => "Şurup"],
            ["form_name" => "Toz"],
            ["form_name" => "Saşe"],
            ["form_name" => "Granül"],
            ["form_name" => "Solüsyon"],
            ["form_name" => "Ovül"],
            ["form_name" => "Supozituar"],
            ["form_name" => "Merhem"],
            ["form_name" => "Losyon"],
            ["form_name" => "Krem"],
            ["form_name" => "Jel"],
            ["form_name" => "Ampul"],
            ["form_name" => "Flakon"],
            ["form_name" => "Efervesan"],
            ["form_name" => "Aerosol"],
            ["form_name" => "Sprey"],
            ["form_name" => "Gargara"],

        ]);
    }
}
/*
Tablet: Efervesan (suda eriyen), pastil (emilen) ve sublingual (dil atında eriyen)

Kapsül: Katı ve sıvı ilaçların silindirik, yassı vb. koruyucu tabaka içinde verildiği şekillerdir.

Draje: Acı olan veya GİS’in bir yerinde açılması için üzeri özel bir tabaka ile kaplı haplardır.

Süspansiyon: Toz şeklinde bulunan su ile karıştırıldıktan sonra kullanılan formdur.

Şurup: Şeker içeren sıvı haldeki ilaç formudur.

Toz: Oral ya da sürülerek kullanılan toz şeklindeki ilaç formudur.

Saşe: Küçük poşetlerdeki toz şeklindeki ilaç formudur.

Granül: Toz ilaçların şurup ile karıştırılarak yassı veya küçük silindir şeklindeki formudur.

Solüsyon: (Göz, kulak damlaları) İlacın su, bitkisel yağ vb. içinde eritilmesiyle oluşan sıvı şeklidir.

Ovül: Vajinal yoldan uygulanan haplardır.

Supozituar: Vajinal veya rektal uygulanan vücut ısısında eriyen fitillerdir.

Pomad(Merhem): Cilde ve mukozaya uygulanan; tereyağı kıvamında  (vazelin, lanolin) yarı katı merhemlerdir.

**Solüsyon ve pomadlar yaygın olarak saçlı deride kullanılırlar.

Losyon: Cilde uygulanan solüsyon, süspansiyon ya da emülsiyon şeklindeki ilaçlardır.

Krem: Cilde ve mukozaya uygulanan yumuşak kıvamlı merhemledir.



** Losyon ve kremler yüz ve vücudun her bölgesinde kullanılabilirler.

Jel: Cilde ve mukozaya uygulanan koyu kıvamlı jellerdir.

Ampul: Sıvı halde ampul içinde bulunan ilaç formudur.

Flakon: Toz halinde içindeki ampul ile sulandırıldıktan sonra kullanılan ilaçlardır.

Aerosol: (İnhaler) solunum yoluyla kullanılan ilaç şekilleridir.
