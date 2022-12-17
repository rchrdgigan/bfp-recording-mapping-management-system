<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fsic extends Model
{
    use HasFactory;

    protected $fillable = [
        'establishment',
        'owner',
        'business_type',
        'contact',
        'address',
        'latitude',
        'longitude',
    ];

    public function fsic_transaction()
    {
        return $this->hasMany(FsicTransaction::class);
    }
}
