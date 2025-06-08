<?php

namespace App\Services;

use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\Interfaces\LanguageServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/**
 * Class LanguageService
 * @package App\Services
 */
class LanguageService implements LanguageServiceInterface
{
    protected $languageRepository;
    protected $userRepository;

    public function __construct(
        LanguageRepository $languageRepository,
        UserRepository $userRepository,
    ) {
        $this->languageRepository = $languageRepository;
        $this->userRepository = $userRepository;
    }

    // Paginate
    public function paginate($request)
    {
        $column = ['id', 'name', 'canonical', 'image', 'publish'];
        $condition = [
            'keyword' => $request->input('keyword'),
            'publish' => $request->input('publish'),
        ];
        $perpage = ($request->integer('perpage') != 0) ? $request->integer('perpage') : 20;
        $extend = ['path' => 'language/index'];

        $languages = $this->languageRepository->paginate($column, $condition, perpage: $perpage, extend: $extend);

        return $languages;
    }

    // Create Store
    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except('_token', 'send');
            $payload['user_id'] = Auth::id();

            $newLanguage = $this->languageRepository->create($payload);

            DB::commit();
            return $newLanguage;
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
            $updateLanguage = $this->languageRepository->update($id, $payload);
            DB::commit();

            return $updateLanguage;
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
            $deleteUser = $this->languageRepository->softDelete($id);
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
            $updateUser = $this->languageRepository->update($post['modelId'], $payload);
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
            $updateUser = $this->languageRepository->updateByWhereIn('id', $post['id'], $payload);
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

    // Switch language
    public function switch($canonical)
    {
        $where = [
            ['canonical', '!=', $canonical],
        ];
        $payload = ['current' => 0];

        DB::beginTransaction();
        try {
            $this->languageRepository->updateByWhere([['canonical', '=', $canonical]], ['current' => 1]);
            $this->languageRepository->updateByWhere($where, $payload);
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
}