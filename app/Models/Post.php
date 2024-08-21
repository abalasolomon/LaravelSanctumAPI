<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory,Notifiable;
    //protected $table = 'Post';
    protected $fillable = [
        'user_id',
        'title',
        'body',
    ];
}
