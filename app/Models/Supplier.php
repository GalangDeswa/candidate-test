<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'uid',
        'name',
        'contact',
        'location',
        'material_certificate',
        'last_audit',
        'status',
    ];

    public function layups()
    {
        return $this->hasMany(Layup::class);
    }
}
