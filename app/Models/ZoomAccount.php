<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomAccount extends Model
{
    use HasFactory;

    protected $fillable = ['account_name', 'client_key', 'client_secret', 'account_id', 'active', 'last_used_at'];
}
