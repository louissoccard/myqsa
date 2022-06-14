<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IcvActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'start_date',
        'end_date',
        'description',
        'part_of_csa',
    ];

    public function qsa_record(): HasOne
    {
        return $this->hasOne(QsaRecord::class);
    }

}
