<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionStage extends Model
{
    protected $fillable = ['product_id', 'stage_name', 'location', 'performed_by', 'notes', 'performed_at', 'blockchain_hash'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
