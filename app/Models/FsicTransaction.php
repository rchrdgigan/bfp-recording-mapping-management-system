<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function getRemainingDaysAttribute()
    {
        $dateNow= Carbon::now()->format('Y-m-d');
        $date= Carbon::parse($dateNow);
        if ($this->valid_until) {
            $remaining_days = $date->diffInDays(Carbon::parse($this->valid_until), false);
        } else {
            $remaining_days = 0;
        }
        return $remaining_days;
    }
}
