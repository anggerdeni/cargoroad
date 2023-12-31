<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        "file_name", "file_path", "product_id", "mime_type", "created_by", "updated_by",
    ];

    protected $hidden = [
        "created_by", "updated_by",
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
