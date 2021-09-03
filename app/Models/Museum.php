<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string imagesUrlStr
 */
class Museum extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function museumType(): BelongsTo
    {
        return $this->belongsTo(MuseumType::class, 'typeId', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'districtId', 'id');
    }


    public function imagesUrls() {
        return array_filter(explode("\r\n", $this->imagesUrlStr), function ($image) {
            return $image !== '';
        });
    }
}
