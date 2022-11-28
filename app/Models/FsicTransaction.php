<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsicTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'valid_for',
        'valid_until',
        'amount',
        'ops_no',
        'or_no',
    ];

    public function fsic()
    {
        return $this->belongsTo(Fsic::class);
    }
}
