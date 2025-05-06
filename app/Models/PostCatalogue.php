<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Traits\QueryScopes;

class PostCatalogue extends Model
{
    use HasFactory, Notifiable, SoftDeletes, QueryScopes;

    protected $table = 'post_catalogues';

    protected $fillable = [
        'parent_id',
        'left',
        'right',
        'level',
        'image',
        'icon',
        'album',
        'publish',
        'follow',
        'order',
        'user_id',
    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class,  'post_catalogue_language', 'post_catalogue_id', 'language_id')
            ->withPivot('name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description')
            ->withTimestamps();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_catalogue_post', 'post_catalogue_id', 'post_id')
            ->withTimestamps();
    }

    public function post_catalogue_language()
    {
        return $this->hasMany(PostCatalogueLanguage::class, 'post_catalogue_id', 'id');
    }

    public static function isNodeCheck($id)
    {
        $post_catalogue = PostCatalogue::find($id);

        return $post_catalogue->right - $post_catalogue->left > 1;
    }
}
