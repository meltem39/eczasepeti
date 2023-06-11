<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('name');                                     // çalışan adı
            $table->string('surname');                                  // çalışan soyado
            $table->string("mobile");                                   // çalışan telefon
            $table->unsignedBigInteger("organization_name")->index();   // eczane id
            $table->enum("job", ["eczaci", "kurye"]);                   // meslek
            $table->string("title");                                    // başlık
            $table->string('email')->unique();                          // mail
            $table->string('password');                                 // şifre
            $table->foreign("organization_name")->references("id")->on("pharmacy_lists")->onDelete("restrict");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacies');
    }
}
