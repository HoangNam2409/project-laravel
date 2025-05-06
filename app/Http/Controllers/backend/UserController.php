<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\Interfaces\UserServiceInterface as UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userRepository;

    public function __construct(
        UserService $userService,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository,

    ) {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
    }

    // Index
    public function index(Request $request)
    {
        $users = $this->userService->paginate($request);
        $config = $this->config();
        $config['seo'] = config('apps.user');
        $template = 'backend.user.user.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'users'));
    }

    // Create
    public function create()
    {
        $provinces = $this->provinceRepository->all();
        $config = $this->config_general();
        $config['seo'] = config('apps.user');
        $config['method'] = 'create';
        $template = 'backend.user.user.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'provinces'));
    }

    // Store
    public function store(StoreUserRequest $request)
    {
        $newUser = $this->userService->create($request);
        if ($newUser) {
            return redirect()->route('user.index')->with(['success' => 'Thêm mới bản ghi thành công.']);
        }

        return redirect()->route('user.index')->with(['error' => 'Thêm mới bản ghi không thành công.']);
    }

    // Edit
    public function edit($id)
    {
        $user = $this->userRepository->findById($id);
        $provinces = $this->provinceRepository->all();
        $config = $this->config_general();
        $config['seo'] = config('apps.user');
        $config['method'] = 'edit';
        $template = 'backend.user.user.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'provinces', 'user'));
    }

    // Update
    public function update(UpdateUserRequest $request, $id)
    {
        $updateUser = $this->userService->update($id, $request);

        if ($updateUser) {
            return redirect()->route('user.index')->with('success', 'Cập nhật bản ghi thành công.');
        }

        return redirect()->route('user.index')->with('error', 'Cập nhật bản ghi không thành công.');
    }

    // Delete
    public function delete($id)
    {
        $user = $this->userRepository->findById($id);
        $config['seo'] = config('apps.user');
        $template = 'backend.user.user.delete';
        return view('backend.dashboard.layout', compact('template', 'config', 'user'));
    }

    // Destroy
    public function destroy($id)
    {
        $delete = $this->userService->destroy($id);
        if ($delete) {
            return redirect()->route('user.index')->with('success', 'Xoá bản ghi thành công.');
        }

        return redirect()->route('user.index')->with('error', 'Xoá bản ghi không thành công.');
    }

    // Config
    private function config()
    {
        return [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'model' => 'User',
        ];
    }

    private function config_merge($array_js = [], $array_css = [])
    {
        $config = $this->config();
        $config['js'] = array_merge($config['js'], $array_js);
        $config['css'] = array_merge($config['css'], $array_css);
        return $config;
    }

    // Config General
    private function config_general()
    {
        return $this->config_merge([
            'backend/plugins/ckfinder_2/ckfinder.js',
            'backend/library/finder.js',
            'backend/library/location.js',
        ]);
    }
}
