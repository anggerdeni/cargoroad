<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "description", "brand_id", "created_by", "updated_by",
    ];

    protected $hidden = [
        "created_by", "updated_by",
    ];

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function productMedia()
    {
        return $this->hasMany('App\Models\ProductMedia');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }
}
