<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_parts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_part')->unique(); // Unique identifier untuk discan/dicari
            $table->string('parent_kode')->nullable();
            $table->string('part_number');
            $table->string('part_name');
            $table->string('project');
            $table->string('customer');
            $table->string('proses');
            $table->timestamps();
            
            // Indexing untuk mempercepat pencarian API saat discan
            $table->index('kode_part');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_parts');
    }
};
