<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HanhTrinh extends Model
{
    use HasFactory;

    protected $table = "hanh_trinhs";

    /**
     * Get the ma_codes that owns the HanhTrinh
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ma_codes(): BelongsTo
    {
        return $this->belongsTo(MaCode::class, 'macode_id');
    }
}
