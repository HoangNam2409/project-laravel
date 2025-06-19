<?php

namespace App\Services;

use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;
use App\Services\Interfaces\PermissionServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class LanguageService
 * @package App\Services
 */
class PermissionService implements PermissionServiceInterface
{
    protected $permissionRepository;

    public function __construct(
        PermissionRepository $permissionRepository,
    ) {
        $this->permissionRepository = $permissionRepository;
    }

    // Paginate
    public function paginate($request)
    {
        $column = ['id', 'name', 'canonical'];
        $condition = [
            'keyword' => $request->input('keyword'),
            'publish' => $request->input('publish'),
        ];
        $perpage = ($request->integer('perpage') != 0) ? $request->integer('perpage') : 20;
        $extend = ['path' => 'permission/index'];

        $permissions = $this->permissionRepository->paginate($column, $condition, perpage: $perpage, extend: $extend);

        return $permissions;
    }

    // Create Store
    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except('_token', 'send');
            $payload['user_id'] = Auth::id();

            $newPermission = $this->permissionRepository->create($payload);

            DB::commit();
            return $newPermission;
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
            $updatePermission = $this->permissionRepository->update($id, $payload);
            DB::commit();

            return $updatePermission;
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
            $this->permissionRepository->softDelete($id);
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
            $this->permissionRepository->update($post['modelId'], $payload);
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
            $updateUser = $this->permissionRepository->updateByWhereIn('id', $post['id'], $payload);
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
}
