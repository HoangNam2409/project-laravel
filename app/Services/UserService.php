<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Paginate
    public function paginate($request)
    {
        $column = ['id', 'email', 'name', 'phone', 'address', 'image', 'publish'];
        $condition['keyword'] = $request->input('keyword');
        $condition['publish'] = $request->input('publish');
        $perpage = ($request->integer('perpage') != 0) ? $request->integer('perpage') : 20;
        $extend = ['path' => 'user/index'];

        $users = $this->userRepository->paginate($column, $condition, perpage: $perpage, extend: $extend);
        return $users;
    }

    // Create Store
    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except('_token', 'send', 're_password');
            $payload['password'] = Hash::make($payload['password']);

            $newUser = $this->userRepository->create($payload);

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
            $updateUser = $this->userRepository->update($id, $payload);
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
            $deleteUser = $this->userRepository->destroy($id);
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
            $updateUser = $this->userRepository->update($post['modelId'], $payload);
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
            $updateUser = $this->userRepository->updateByWhereIn('id', $post['id'], $payload);
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
