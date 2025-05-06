<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Language extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'languages';

    protected $fillable = [
        'name',
        'canonical',
        'publish',
        'image',
        'user_id',
    ];

    public function post_catalogues()
    {
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_language', 'language_id', 'post_catalogue_id')
            ->withPivot('name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description')
            ->withTimestamps();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_language', 'language_id', 'post_id')
            ->withPivot('name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description')
            ->withTimestamps();
    }
}