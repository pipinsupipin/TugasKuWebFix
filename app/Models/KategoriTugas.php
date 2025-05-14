<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriTugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_kategori',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kategori_id');
    }
}
