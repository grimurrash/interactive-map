<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string video
 */
class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function type(): BelongsTo
    {
        return $this->belongsTo(SubjectType::class, 'typeId', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'districtId', 'id');
    }
}
