<?php

namespace App\Repositories;

use App\Models\PostCatalogue;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface;

/**
 * Class PostCatalogueRepository
 * @package App\Repositories
 */
class PostCatalogueRepository extends BaseRepository implements PostCatalogueRepositoryInterface
{
    protected $model;

    public function __construct(PostCatalogue $model)
    {
        $this->model = $model;
    }

    public function getPostCatalogueById(int $id = 0, int $language_id = 0)
    {
        return $this->model
            ->join('post_catalogue_language as tb2', 'tb2.post_catalogue_id', '=', 'post_catalogues.id')
            ->select([
                'post_catalogues.id',
                'post_catalogues.parent_id',
                'post_catalogues.image',
                'post_catalogues.album',
                'post_catalogues.publish',
                'post_catalogues.follow',
                'tb2.name',
                'tb2.canonical',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
            ])
            ->where('tb2.language_id', '=', '1')
            ->findOrFail($id);
    }
}
