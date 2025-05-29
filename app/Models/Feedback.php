<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'kategori',
        'nama_lengkap', 
        'email',
        'rating',
        'judul',
        'detail_kritik_saran',
        'file_pendukung',
        'is_public',
        'is_read',
        'read_at',
        'admin_response',
        'responded_by',
        'responded_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_public' => 'boolean',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    // Accessor untuk file URL
    public function getFilePendukungUrlAttribute()
    {
        if ($this->file_pendukung) {
            return asset('storage/feedback_files/' . $this->file_pendukung);
        }
        return null;
    }

    // Scope untuk filter
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Method untuk rating bintang
    public function getRatingStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    // Method untuk kategori options
    public static function getKategoriOptions()
    {
        return [
            'layanan' => 'Layanan',
            'aplikasi' => 'Aplikasi', 
            'website' => 'Website',
            'produk' => 'Produk',
            'lainnya' => 'Lainnya'
        ];
    }

    // Format kategori display
    public function getKategoriDisplayAttribute()
    {
        $options = self::getKategoriOptions();
        return $options[$this->kategori] ?? ucfirst($this->kategori);
    }
}