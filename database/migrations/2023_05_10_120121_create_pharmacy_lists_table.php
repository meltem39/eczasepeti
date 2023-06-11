<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmacyListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacy_lists', function (Blueprint $table) {
            $table->id();
            $table->string("name");         // eczane ado
            $table->string("city");         // şehir
            $table->string("district");     // ilçe
            $table->text("address");        // açık adres
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
        Schema::dropIfExists('pharmacy_lists');
    }
}
