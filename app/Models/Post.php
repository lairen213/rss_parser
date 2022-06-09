<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected  $table = 'posts';
    public $timestamps = false;//если created_at, updated_at нету

    protected $fillable = [
        'slug',
        'title',
        'link',
        'description',
        'author',
        'categories',
        'date',
        'deleted'
    ];
}
