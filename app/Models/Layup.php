<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layup extends Model
{
      protected $fillable = [
        'uid',
        'supplier_id',
        'name',
        'species',
        'grade',
        'revision',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function layers()
    {
        return $this->hasMany(Layer::class);
    }
    
}
