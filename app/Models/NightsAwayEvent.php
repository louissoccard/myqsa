<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NightsAwayEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'type',
        'number_of_nights',
    ];

    public function qsa_record(): HasOne
    {
        return $this->hasOne(QsaRecord::class);
    }
}
