<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class users extends Model
{
    //
    protected $guarded =[];
    public function tugas(): HasMany
    {
        return $this->hasMany(tugas::class);
    }
}
