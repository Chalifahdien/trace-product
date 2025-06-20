<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['product_id', 'title', 'file_path', 'issued_by', 'issued_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
