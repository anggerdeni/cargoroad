<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        "name", "address", "created_by"
    ];

    protected $hidden = [
        "created_by", "updated_by",
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
