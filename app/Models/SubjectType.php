<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string name
 */
class SubjectType extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'typeId', 'id');
    }
}
