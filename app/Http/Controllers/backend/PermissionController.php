<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;
use App\Services\Interfaces\PermissionServiceInterface as PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    protected $permissionService;
    protected $permissionRepository;

    public function __construct(
        PermissionService $permissionService,
        PermissionRepository $permissionRepository,

    ) {
        $this->permissionService = $permissionService;
        $this->permissionRepository = $permissionRepository;
    }

    // Index
    public function index(Request $request)
    {
        Gate::authorize('modules', 'permission.index');
        $permissions = $this->permissionService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.permission');
        $template = 'backend.permission.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'permissions'));
    }

    // Create
    public function create()
    {
        Gate::authorize('modules', 'permission.create');
        $config = $this->config_general();
        $config['seo'] = __('messages.permission');
        $config['method'] = 'create';

        $template = 'backend.permission.store';
        return view('backend.dashboard.layout', compact('template', 'config'));
    }

    // Store
    public function store(StorePermissionRequest $request)
    {
        $newPermission = $this->permissionService->create($request);
        if ($newPermission) {
            return redirect()->route('permission.index')->with(['success' => 'Thêm mới bản ghi thành công.']);
        }

        return redirect()->route('permission.index')->with(['error' => 'Thêm mới bản ghi không thành công.']);
    }

    // Edit
    public function edit($id)
    {
        Gate::authorize('modules', 'permission.update');
        $permission = $this->permissionRepository->findById($id);
        $config = $this->config_general();
        $config['seo'] = __('messages.permission');
        $config['method'] = 'edit';
        $template = 'backend.permission.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'permission'));
    }

    // Update
    public function update(UpdatePermissionRequest $request, $id)
    {
        $updatePermission = $this->permissionService->update($id, $request);

        if ($updatePermission) {
            return redirect()->route('permission.index')->with('success', 'Cập nhật bản ghi thành công.');
        }

        return redirect()->route('permission.index')->with('error', 'Cập nhật bản ghi không thành công.');
    }

    // Delete
    public function delete($id)
    {
        Gate::authorize('modules', 'permission.destroy');
        $permission = $this->permissionRepository->findById($id);
        $config['seo'] = __('messages.permission');
        $template = 'backend.permission.delete';
        return view('backend.dashboard.layout', compact('template', 'config', 'permission'));
    }

    // Destroy
    public function destroy($id)
    {
        $delete = $this->permissionService->destroy($id);
        if ($delete) {
            return redirect()->route('permission.index')->with('success', 'Xoá bản ghi thành công.');
        }

        return redirect()->route('permission.index')->with('error', 'Xoá bản ghi không thành công.');
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
            'model' => 'Language',
        ];
    }

    // Config_merge
    private function config_merge($array_js = [], $array_css = [])
    {
        $config = $this->config();
        $config['js'] = array_merge($config['js'], $array_js);
        $config['css'] = array_merge($config['css'], $array_css);
        return $config;
    }

    // Config create and update
    private function config_general()
    {
        return $this->config_merge([
            'backend/plugins/ckfinder_2/ckfinder.js',
            'backend/library/finder.js',
        ]);
    }
}
