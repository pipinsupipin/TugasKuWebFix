<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tugas extends Model
{
    //
    protected $guarded =[];
    public function kategori()
{
    return $this->belongsTo(Kategori::class, 'id_kategori');
}


    public function users(): BelongsTo
{
    return $this->belongsTo(users::class);
}
}
