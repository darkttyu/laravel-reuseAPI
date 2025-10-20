<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailToken extends Model
{
    protected $table = 'email_verification_tokens';

    protected $primaryKey = 'email';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    protected $hidden = [
        'token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
