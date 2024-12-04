<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'information_id',
        'user_id',
        'action',
        'changes',
    ];

    public function information()
    {
        return $this->belongsTo(Information::class);
    }
}
