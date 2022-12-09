<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fsec extends Model
{
    use HasFactory;

    protected $fillable = [
        'fsec_no',
        'establishment',
        'owner',
        'contact',
        'address',
        'latitude',
        'longitude',
    ];

    public function fsec_transaction()
    {
        return $this->hasMany(FsecTransaction::class);
    }
}
