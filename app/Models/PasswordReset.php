<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $casts = [ 'created_at'=>'datetime'];

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}
