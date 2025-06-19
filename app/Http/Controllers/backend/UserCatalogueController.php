<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalogueRequest;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Services\Interfaces\UserCatalogueServiceInterface as UserCatalogueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userCatalogueRepository;
    protected $permissionRepository;

    public function __construct(
        UserCatalogueService $userCatalogueService,
        UserCatalogueRepository $userCatalogueRepository,
        PermissionRepository $permissionRepository,
    ) {
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
        $this->permissionRepository = $permissionRepository;
    }

    // Index
    public function index(Request $request)
    {
        Gate::authorize('modules', 'user.catalogue.index');
        $user_catalogues = $this->userCatalogueService->paginate($request);
        $config = $this->config();
        $config['seo'] = config('apps.usercatalogue');
        $template = 'backend.user.catalogue.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'user_catalogues'));
    }

    // Create
    public function create()
    {
        Gate::authorize('modules', 'user.catalogue.create');
        $config['seo'] = config('apps.usercatalogue');
        $config['method'] = 'create';
        $template = 'backend.user.catalogue.store';
        return view('backend.dashboard.layout', compact('template', 'config'));
    }

    // Store
    public function store(StoreUserCatalogueRequest $request)
    {
        $newUser = $this->userCatalogueService->create($request);
        if ($newUser) {
            return redirect()->route('user.catalogue.index')->with(['success' => 'Thêm mới bản ghi thành công.']);
        }

        return redirect()->route('user.catalogue.index')->with(['error' => 'Thêm mới bản ghi không thành công.']);
    }

    // Edit
    public function edit($id)
    {
        Gate::authorize('modules', 'user.catalogue.update');
        $user_catalogue = $this->userCatalogueRepository->findById($id);
        $config['seo'] = config('apps.usercatalogue');
        $config['method'] = 'edit';
        $template = 'backend.user.catalogue.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'user_catalogue'));
    }

    // Update
    public function update(StoreUserCatalogueRequest $request, $id)
    {
        $updateUser = $this->userCatalogueService->update($id, $request);

        if ($updateUser) {
            return redirect()->route('user.catalogue.index')->with('success', 'Cập nhật bản ghi thành công.');
        }

        return redirect()->route('user.catalogue.index')->with('error', 'Cập nhật bản ghi không thành công.');
    }

    // Delete
    public function delete($id)
    {
        Gate::authorize('modules', 'user.catalogue.destroy');
        $user_catalogue = $this->userCatalogueRepository->findById($id);
        $config['seo'] = config('apps.usercatalogue');
        $template = 'backend.user.catalogue.delete';
        return view('backend.dashboard.layout', compact('template', 'config', 'user_catalogue'));
    }

    // Destroy
    public function destroy($id)
    {
        $delete = $this->userCatalogueService->destroy($id);
        if ($delete) {
            return redirect()->route('user.catalogue.index')->with('success', 'Xoá bản ghi thành công.');
        }

        return redirect()->route('user.catalogue.index')->with('error', 'Xoá bản ghi không thành công.');
    }

    // Permission
    public function permission()
    {
        $userCatalogues = $this->userCatalogueRepository->all(['permissions']);
        $permissions = $this->permissionRepository->all();
        $config['seo'] = __('messages.permission');
        $template = 'backend.user.catalogue.permission';
        return view('backend.dashboard.layout', compact('template', 'config', 'userCatalogues', 'permissions'));
    }

    // Update Permission
    public function updatePermission(Request $request)
    {
        $permissions = $request->input('permissions', []);

        if ($this->userCatalogueService->setPermission($permissions)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Cập nhật quyền thành công.');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Cập nhật quyền không thành công.');
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
            'model' => 'UserCatalogue',
        ];
    }
}
