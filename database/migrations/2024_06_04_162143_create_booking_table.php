<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug');
            $table->string('nama');
            $table->string('alamat');
            $table->string('email');
            $table->string('noHp');
            $table->date('tanggal_mulai_penggunaan');
            $table->date('tanggal_berakhir_penggunaan');
            $table->time('jam_mulai_penggunaan');
            $table->time('jam_berakhir_penggunaan');
            $table->decimal('total', 10, 2);
            $table->decimal('dp', 10, 2)->default(0);
            $table->string('keterangan');
            $table->string('status')->default('Pending');
            $table->string('payment_status')->default('Pending');
            $table->string('payment_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
