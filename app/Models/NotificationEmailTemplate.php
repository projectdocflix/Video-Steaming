<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationEmailTemplate extends Model
{
    protected $fillable = [
        'category',
        'slug',
        'subject',
        'body',
        'variables',
        'status',
    ];
}
