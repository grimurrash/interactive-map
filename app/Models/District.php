<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string name
 */
class District extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function subjects(): HasMany
    {
       return $this->HasMany(Subject::class,'districtId','id');
    }

    public function polygons(): HasMany
    {
        return $this->hasMany(Polygon::class, 'districtId','id');
    }
}
