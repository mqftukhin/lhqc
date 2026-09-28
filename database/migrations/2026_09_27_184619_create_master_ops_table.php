<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_ops', function (Blueprint $table) {
            $table->id();
            $table->string('id_op')->unique(); // Kode unik untuk nama operator / ID
            $table->string('name_op');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_ops');
    }
};
