<?php

namespace App\Services;

use App\Services\Interfaces\PostServiceInterface;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class PostService
 * @package App\Services
 */
class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;
    protected $userRepository;

    public function __construct(
        PostRepository $postRepository,
        UserRepository $userRepository,
    ) {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    // Paginate
    public function paginate($request)
    {
        $column = $this->paginateSelect();
        $condition['keyword'] = $request->input('keyword');
        $condition['publish'] = $request->input('publish');
        $condition['where'] = [
            ['tb2.language_id', '=', '1'],
        ];
        $join = [
            [
                'post_language as tb2',
                'tb2.post_id',
                '=',
                'posts.id',
            ],
            [
                'post_catalogue_post as tb3',
                'posts.id',
                '=',
                'tb3.post_id',
            ]
        ];
        $orderBy = ['posts.id' => 'desc'];
        $perpage = ($request->integer('perpage') != 0) ? $request->integer('perpage') : 20;
        $extend = ['path' => 'post/index', 'groupBy' => $this->paginateSelect()];

        // Lọc nhóm bài viết
        // Lấy ra id các mục con => sau đó whereIn post_catalogue_id trong bảng post_catalgoue_post IN (id danh mục con)
        $rawQuery = $this->whereRaw($request);

        $posts = $this->postRepository->paginate($column, $condition, join: $join, orderBy: $orderBy, perpage: $perpage, extend: $extend, rawQuery: $rawQuery);

        return $posts;
    }

    // Create Store
    public function create($request)
    {
        DB::beginTransaction();
        try {
            // Thêm dữ liệu vào bảng Post
            $payload = $this->payloadPost($request);
            $payload['user_id'] = Auth::id();
            $payload['album'] = $this->formatAlbum($request);

            $newPost = $this->postRepository->create($payload);

            // Thêm dữ liệu vào bảng Pivot post_language
            if ($newPost) {
                $payloadLanguage = $this->payloadLanguage($request);
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_id'] = $newPost->id;

                $this->postRepository->createPivot($newPost, $payloadLanguage, 'languages');
                // Thêm dữ liệu vào bảng Pivot post_catalogue_post
                if ($request->input('catalogue') != null) {
                    $catalogue = $this->catalogue($request);
                } else {
                    $catalogue[] = $request->input('post_catalogue_id');
                }

                $newPost->post_catalogues()->sync($catalogue);
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

    // Update User
    public function update($id, $request)
    {
        DB::beginTransaction();

        try {
            $post = $this->postRepository->findById($id);
            $payload = $this->payloadPost($request);
            $payload['album'] = $this->formatAlbum($request);

            // Cập nhật dữ liệu vào bảng post
            $updatePost = $this->postRepository->update($id, $payload);
            if ($updatePost) {
                $payloadLanguage = $this->payloadLanguage($request);
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $payloadLanguage['language_id'] = 1;
                // Xoá bỏ bản ghi trong bảng pivot
                $this->postRepository->detachPivot($post, [$payloadLanguage['language_id'], $id], 'languages');
                // Thêm bản ghi mới vào trong bảng pivot
                $this->postRepository->createPivot($post, $payloadLanguage, 'languages');
                // Cập nhật lại bảng pivot post_catalogue_post
                if ($request->input('catalogue') != null) {
                    $catalogue = $this->catalogue($request);
                } else {
                    $catalogue[] = $request->input('post_catalogue_id');
                }
                $post->post_catalogues()->sync($catalogue);
            }
            DB::commit();

            return $updatePost;
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
            $this->postRepository->softDelete($id);
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
            $this->postRepository->update($post['modelId'], $payload);
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
            $this->postRepository->updateByWhereIn('id', $post['id'], $payload);
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
    //         $this->userRepository->updateByWhereIn('user__id', $array, $payload);
    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         echo $e->getMessage();
    //         die();
    //     }
    // }

    // Where Raw
    private function whereRaw($request)
    {
        $rawCondition = [];
        // Kiểm tra post_catalogue_id có tồn tại không
        if ($request->integer('post_catalogue_id') > 0) {
            $rawCondition['whereRaw'] = [
                [
                    // Câu lệnh thuần => Lọc ra post_catalogue_id nằm trong danh sách các nhóm bài viết (post_catalogues)
                    'tb3.post_catalogue_id IN (
                        SELECT id
                        FROM post_catalogues
                        WHERE `left` >= (SELECT `left` FROM post_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM post_catalogues as pc WHERE pc.id = ?)
                    )',
                    // Biding với giá trị ?
                    [$request->integer('post_catalogue_id'), $request->integer('post_catalogue_id')],
                ]
            ];
        }

        return $rawCondition;
    }

    private function formatAlbum($request)
    {
        if ($request->input('album') && !empty($request->input('album'))) {
            return json_encode($request->input('album'));
        }
        return null;
    }

    private function paginateSelect()
    {
        return [
            'posts.id',
            'posts.image',
            'posts.publish',
            'posts.order',
            'tb2.name',
            'tb2.canonical'
        ];
    }

    // Catalogue
    private function catalogue($request)
    {

        return array_unique(array_merge($request->input('catalogue'), [$request->input('post_catalogue_id')]));
    }

    // Payload
    private function payloadPost($request)
    {
        return $request->only('image', 'album', 'publish', 'follow', 'user_id', 'post_catalogue_id');
    }

    private function payloadLanguage($request)
    {
        return $request->only('name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description');
    }
}
