<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'uuid';
    protected $casts = [
        'uuid' => 'string'
    ];

    public function property()
    {
        return $this->belongsTo(PropertyType::class, 'property_type', 'id');
    }
}
