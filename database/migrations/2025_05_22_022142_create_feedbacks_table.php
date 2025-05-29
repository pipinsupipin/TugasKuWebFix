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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['layanan', 'aplikasi', 'website', 'produk', 'lainnya']);
            $table->string('nama_lengkap');
            $table->string('email');
            $table->integer('rating')->comment('Rating 1-5 stars');
            $table->string('judul');
            $table->text('detail_kritik_saran');
            $table->string('file_pendukung')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->text('admin_response')->nullable();
            $table->unsignedBigInteger('responded_by')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['kategori', 'created_at']);
            $table->index(['rating', 'created_at']);
            $table->index(['is_read', 'created_at']);
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};