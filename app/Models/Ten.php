<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ten extends Model
{
    use HasFactory;

    protected $table = "tens";

    /**
     * Get the ma_codes that owns the Ten
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ma_codes(): BelongsTo
    {
        return $this->belongsTo(MaCode::class, 'macode_id');
    }
}
