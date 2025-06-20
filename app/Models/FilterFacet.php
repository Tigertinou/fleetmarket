<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterFacet extends Model
{
    protected $fillable = [
        'facet_type',
        'value',
        'label_en',
        'label_fr',
        'label_nl',
        'count',
        'position',
    ];
}
