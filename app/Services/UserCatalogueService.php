<?php

namespace App\Services;

use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\Interfaces\UserCatalogueServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/**
 * Class UserCatalogueService
 * @package App\Services
 */
class UserCatalogueService implements UserCatalogueServiceInterface
{
    protected $userCatalogueRepository;
    protected $userRepository;

    public function __construct(
        UserCatalogueRepository $userCatalogueRepository,
        UserRepository $userRepository,
    ) {
        $this->userCatalogueRepository = $userCatalogueRepository;
        $this->userRepository = $userRepository;
    }

    // Paginate
    public function paginate($request)
    {
        $column = ['id', 'name', 'description', 'publish'];
        $condition = [
            'keyword' => $request->input('keyword'),
            'publish' => $request->input('publish'),
        ];
        $relations = ['users'];
        $perpage = ($request->integer('perpage') != 0) ? $request->integer('perpage') : 20;
        $extend = ['path' => 'user/catalogue/index'];

        $user_catalogues = $this->userCatalogueRepository->paginate($column, $condition, $relations, perpage: $perpage, extend: $extend);

        return $user_catalogues;
    }

    // Create Store
    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except('_token', 'send');

            $newUser = $this->userCatalogueRepository->create($payload);

            DB::commit();
            return $newUser;
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
            $payload = $request->except('_token', 'send');
            $updateUser = $this->userCatalogueRepository->update($id, $payload);
            DB::commit();

            return $updateUser;
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
            $deleteUser = $this->userCatalogueRepository->softDelete($id);
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
            $updateUser = $this->userCatalogueRepository->update($post['modelId'], $payload);
            $this->changeStatusUser($post, $payload);
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
            $updateUser = $this->userCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);
            $this->changeStatusUser($post, $payload);
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
    private function changeStatusUser($post = [], array $payload = [])
    {
        if (isset($post['modelId'])) {
            $array[] = $post['modelId'];
        } else {
            $array = $post['id'];
        }

        DB::beginTransaction();
        try {
            $this->userRepository->updateByWhereIn('user_catalogue_id', $array, $payload);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
        }
    }
}