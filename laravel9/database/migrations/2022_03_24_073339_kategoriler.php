<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategoriler', function (Blueprint $table) {
            $table->id();
            $table->string("başlık",255);
            $table->string("selflink",255);
            $table->string("tablo",255)->nullable();
            $table->string("anahtar",255)->nullable();
            $table->string("description",255)->nullable();
            $table->enum("durum",[1,2])->default(1);
            $table->integer("sira_no")->nullable();
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
        Schema::dropIfExists('kategoriler');
    }
};
