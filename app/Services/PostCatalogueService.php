<?php

namespace App\Services;

use App\Services\Interfaces\PostcatalogueServiceInterface;
use App\Classes\Nestedsetbie;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/**
 * Class LanguageService
 * @package App\Services
 */
class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    protected $routerRepository;
    protected $userRepository;
    protected $nestedset;

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        RouterRepository $routerRepository,
        UserRepository $userRepository,
    ) {
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->routerRepository = $routerRepository;
        $this->userRepository = $userRepository;
        $this->controller_name = 'PostCatalogueController';
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1,
        ]);
    }

    // Paginate
    public function paginate($request)
    {
        $column = [
            'post_catalogues.id',
            'post_catalogues.level',
            'post_catalogues.image',
            'post_catalogues.publish',
            'tb2.name',
            'tb2.canonical'
        ];
        $condition = [
            'keyword' => $request->input('keyword'),
            'publish' => $request->input('publish'),
            'where' => [
                ['tb2.language_id', '=', '1'],
            ],
        ];
        $join = [
            [
                'post_catalogue_language as tb2',
                'tb2.post_catalogue_id',
                '=',
                'post_catalogues.id',
            ]
        ];
        $orderBy = ['post_catalogues.left' => 'asc'];
        $perpage = ($request->integer('perpage') != 0) ? $request->integer('perpage') : 20;
        $extend = ['path' => 'post/catalogue/index'];

        $postCatalogues = $this->postCatalogueRepository->paginate($column, $condition, join: $join, orderBy: $orderBy, perpage: $perpage, extend: $extend);

        return $postCatalogues;
    }

    // Create Store
    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $this->payloadPostCatalogue($request);
            $payload['user_id'] = Auth::id();
            $payload['album'] = $this->formatAlbum($request);

            $newPostCatalogue = $this->postCatalogueRepository->create($payload);

            if ($newPostCatalogue) {
                $payloadLanguage = $this->payloadLanguage($request);
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_catalogue_id'] = $newPostCatalogue->id;

                $this->postCatalogueRepository->createPivot($newPostCatalogue, $payloadLanguage, 'languages');

                // Thêm dữ liệu url vào bảng routers
                $this->createRouter($newPostCatalogue, $payloadLanguage['canonical']);

                // Nested
                $this->nestedset();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    // Update Store
    public function update($id, $request)
    {
        DB::beginTransaction();

        try {
            $postCatalogue = $this->postCatalogueRepository->findById($id);
            $payload = $this->payloadPostCatalogue($request);
            $payload['album'] = $this->formatAlbum($request);

            $updatePostCatalogue = $this->postCatalogueRepository->update($id, $payload);
            if ($updatePostCatalogue) {
                $payloadLanguage = $this->payloadLanguage($request);
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $payloadLanguage['language_id'] = 1;
                $payloadLanguage['post_catalogue_id'] = $id;
                // Xoá bỏ bản ghi trong bảng pivot
                $this->postCatalogueRepository->detachPivot($postCatalogue, $payloadLanguage, 'languages');
                // Thêm bản ghi mới vào trong bảng pivot
                $this->postCatalogueRepository->createPivot($postCatalogue, $payloadLanguage, 'languages');

                // Update dữ liệu url
                $this->updateRouter($postCatalogue, $payloadLanguage['canonical']);

                // Update Nested Set
                $this->nestedset();
            }
            DB::commit();

            return $updatePostCatalogue;
            dd($payload);
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    // Delete User
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->postCatalogueRepository->softDelete($id);
            // Sau khi xoá node cần cập nhật lại node
            $this->nestedset->Get();
            $this->nestedset->Recursive(0, $this->nestedset->Set());
            $this->nestedset->Action();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    // Update Status
    public function updateStatus($post = [])
    {
        $payload = [
            $post['field'] => (($post['value'] == 2) ? 1 : 2),
        ];

        DB::beginTransaction();
        try {
            $this->postCatalogueRepository->update($post['modelId'], $payload);
            // $this->changeStatusUser($post, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    // Update Status All
    public function updateStatusAll($post = [])
    {
        $payload = [
            $post['field'] => $post['value'],
        ];

        DB::beginTransaction();
        try {
            $this->postCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);
            // $this->changeStatusUser($post, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    // Change Status User
    // private function changeStatusUser($post = [], array $payload = [])
    // {
    //     if (isset($post['modelId'])) {
    //         $array[] = $post['modelId'];
    //     } else {
    //         $array = $post['id'];
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $this->userRepository->updateByWhereIn('user_catalogue_id', $array, $payload);
    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         echo $e->getMessage();
    //         die();
    //     }
    // }

    private function formatAlbum($request)
    {
        if ($request->input('album') && !empty($request->input('album'))) {
            return json_encode($request->input('album'));
        }
        return null;
    }

    // Payload
    private function payloadPostCatalogue($request)
    {
        return $request->only('parent_id', 'image', 'album', 'publish', 'follow', 'user_id');
    }

    private function payloadLanguage($request)
    {
        return $request->only('name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description');
    }

    // Nested Set
    private function nestedset()
    {
        $this->nestedset->Get();
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();
    }
}