<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaCode extends Model
{
    use HasFactory;

    protected $table = "ma_codes";
    
    /**
     * Get all of the tens for the MaCode
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tens(): HasMany
    {
        return $this->hasMany(Ten::class, 'macode_id', 'id');
    }

    /**
     * Get all of the hanh_trinhs for the MaCode
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hanh_trinhs(): HasMany
    {
        return $this->hasMany(HanhTrinh::class, 'macode_id', 'id');
    }
}
