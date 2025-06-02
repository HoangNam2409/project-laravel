<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Services\Interfaces\LanguageServiceInterface as LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    protected $languageService;
    protected $languageRepository;

    public function __construct(
        LanguageService $languageService,
        LanguageRepository $languageRepository,

    ) {
        $this->languageService = $languageService;
        $this->languageRepository = $languageRepository;
    }

    // Index
    public function index(Request $request)
    {
        $languages = $this->languageService->paginate($request);
        $config = $this->config();
        $config['seo'] = config('apps.language');
        $template = 'backend.language.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'languages'));
    }

    // Create
    public function create()
    {
        $config = $this->config_general();
        $config['seo'] = config('apps.language');
        $config['method'] = 'create';

        $template = 'backend.language.store';
        return view('backend.dashboard.layout', compact('template', 'config'));
    }

    // Store
    public function store(StoreLanguageRequest $request)
    {
        $newLanguage = $this->languageService->create($request);
        if ($newLanguage) {
            return redirect()->route('language.index')->with(['success' => 'Thêm mới bản ghi thành công.']);
        }

        return redirect()->route('language.index')->with(['error' => 'Thêm mới bản ghi không thành công.']);
    }

    // Edit
    public function edit($id)
    {
        $language = $this->languageRepository->findById($id);
        $config = $this->config_general();
        $config['seo'] = config('apps.language');
        $config['method'] = 'edit';
        $template = 'backend.language.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'language'));
    }

    // Update
    public function update(UpdateLanguageRequest $request, $id)
    {
        $updateLanguage = $this->languageService->update($id, $request);

        if ($updateLanguage) {
            return redirect()->route('language.index')->with('success', 'Cập nhật bản ghi thành công.');
        }

        return redirect()->route('language.index')->with('error', 'Cập nhật bản ghi không thành công.');
    }

    // Delete
    public function delete($id)
    {
        $language = $this->languageRepository->findById($id);
        $config['seo'] = config('apps.language');
        $template = 'backend.language.delete';
        return view('backend.dashboard.layout', compact('template', 'config', 'language'));
    }

    // Destroy
    public function destroy($id)
    {
        $delete = $this->languageService->destroy($id);
        if ($delete) {
            return redirect()->route('language.index')->with('success', 'Xoá bản ghi thành công.');
        }

        return redirect()->route('language.index')->with('error', 'Xoá bản ghi không thành công.');
    }

    // Switch backend language
    public function switchBackendLanguage($canonical)
    {
        if ($this->languageService->switch($canonical)) {
            // Session::put('app_locale', $canonical);
            session(['app_locale' => $canonical]);
            App::setLocale($canonical);
        };

        // echo App::getLocale();

        return redirect()->back();
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