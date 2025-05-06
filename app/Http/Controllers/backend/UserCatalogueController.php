<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalogueRequest;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Services\Interfaces\UserCatalogueServiceInterface as UserCatalogueService;
use Illuminate\Http\Request;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $provinceRepository;
    protected $userCatalogueRepository;

    public function __construct(
        UserCatalogueService $userCatalogueService,
        UserCatalogueRepository $userCatalogueRepository,

    ) {
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
    }

    // Index
    public function index(Request $request)
    {
        $user_catalogues = $this->userCatalogueService->paginate($request);
        $config = $this->config();
        $config['seo'] = config('apps.usercatalogue');
        $template = 'backend.user.catalogue.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'user_catalogues'));
    }

    // Create
    public function create()
    {
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
