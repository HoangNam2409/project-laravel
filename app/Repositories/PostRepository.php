<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

/**
 * Class PostRepository
 * @package App\Repositories
 */
class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function getPostById(int $id = 0, int $language_id = 0)
    {
        return $this->model
            ->join('post_language as tb2', 'tb2.post_id', '=', 'posts.id')
            ->select([
                'posts.id',
                'posts.post_catalogue_id',
                'posts.image',
                'posts.album',
                'posts.publish',
                'posts.follow',
                'tb2.name',
                'tb2.canonical',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
            ])
            ->where('tb2.language_id', '=', '1')
            ->with('post_catalogues')
            ->findOrFail($id);
    }
}
