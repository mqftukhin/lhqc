<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qc_records', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys (Menghubungkan ke tabel master)
            $table->foreignId('master_part_id')->constrained('master_parts')->onDelete('cascade');
            $table->foreignId('master_op_id')->constrained('master_ops')->onDelete('cascade');
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');
            
            // Core QC Data
            $table->date('tanggal_qc'); // Diisi otomatis lewat sistem backend
            $table->time('time_awal');
            $table->time('time_akhir');
            $table->string('lot');
            
            // Kuantitas & Keterangan
            $table->integer('ok')->default(0);
            $table->integer('ngr')->default(0);
            $table->string('ket_ngr')->nullable();
            $table->integer('ngt')->default(0);
            $table->string('ket_ngt')->nullable();
            $table->string('ket_losttime')->nullable();
            
            $table->timestamps();

            // Index untuk kebutuhan filter report berdasarkan tanggal dan shift
            $table->index(['tanggal_qc', 'shift_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qc_records');
    }
};
