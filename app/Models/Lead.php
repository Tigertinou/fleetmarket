<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lead extends Model
{

    protected $fillable = [
        'ref',
        'lang',
        'firstname',
        'lastname',
        'email',
        'phone',
        'postcode',
        'message',
        'make_id',
        'model_id',
        'version_id',
        'status',
        'data',
        'date_create'
    ];

    protected $casts = [
        'data' => 'array',
        'date_create' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($lead) {
            do {
                $lead->ref = strtoupper(Str::random(8));
            } while (Lead::where('ref', $lead->ref)->exists());
        });
    }
}
