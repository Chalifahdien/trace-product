<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'material', 'image', 'qr_code', 'blockchain_hash'];

    public function produsen()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stages()
    {
        return $this->hasMany(ProductionStage::class);
    }

    public function distributions()
    {
        return $this->hasMany(Distribution::class);
    }

    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
