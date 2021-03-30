<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MuseumType extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function museums(): HasMany
    {
        return $this->hasMany(Museum::class, 'typeId', 'id');
    }
}
