<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_admin')->unsigned();
            $table->foreign('id_admin')->references('id')->on('admin')->onDelete('cascade')->onUpdate('cascade');
            $table->string("judul");
            $table->text("deskripsi")->nullable();
            $table->string("gambar", 70)->nullable();
            $table->date("tanggal_pelaksanaan");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
