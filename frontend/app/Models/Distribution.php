<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $fillable = ['product_id', 'user_id', 'destination', 'received_by', 'distributed_at', 'notes', 'blockchain_hash'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function distributor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
