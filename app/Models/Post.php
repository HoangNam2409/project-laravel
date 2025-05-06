<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Traits\QueryScopes;

class Post extends Model
{
    use HasFactory, Notifiable, SoftDeletes, QueryScopes;

    protected $table = 'posts';

    protected $fillable = [
        'id',
        'post_catalogue_id',
        'image',
        'album',
        'order',
        'publish',
        'follow',
        'user_id',
    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'post_language', 'post_id', 'language_id')
            ->withPivot('name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description')
            ->withTimestamps();
    }

    public function post_catalogues()
    {
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_post', 'post_id', 'post_catalogue_id')
            ->withTimestamps();
    }
}
