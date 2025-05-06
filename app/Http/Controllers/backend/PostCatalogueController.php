<?php

namespace App\Http\Controllers\backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostCatalogueRequest;
use App\Http\Requests\StorePostCatalogueRequest;
use App\Http\Requests\UpdatePostCatalogueRequest;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use Illuminate\Http\Request;

class PostCatalogueController extends Controller
{
    protected $postCatalogueService;
    protected $postCatalogueRepository;
    protected $nestedset;

    public function __construct(
        PostCatalogueService $postCatalogueService,
        PostCatalogueRepository $postCatalogueRepository,
    ) {
        $this->postCatalogueService = $postCatalogueService;
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1,
        ]);
    }

    // Index
    public function index(Request $request)
    {
        $post_catalogues = $this->postCatalogueService->paginate($request);
        $config = $this->config();
        $config['seo'] = config('apps.postcatalogue');
        $template = 'backend.post.catalogue.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'post_catalogues'));
    }

    // Create
    public function create()
    {
        $config = $this->config_general();
        $config['seo'] = config('apps.postcatalogue');
        $config['method'] = 'create';
        $dropdown = $this->nestedset->Dropdown();

        $template = 'backend.post.catalogue.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'dropdown'));
    }

    // Store
    public function store(StorePostCatalogueRequest $request)
    {
        $new_post_catalogue = $this->postCatalogueService->create($request);
        if ($new_post_catalogue) {
            return redirect()->route('post.catalogue.index')->with(['success' => 'Thêm mới bản ghi thành công.']);
        }

        return redirect()->route('post.catalogue.index')->with(['error' => 'Thêm mới bản ghi không thành công.']);
    }

    // Edit
    public function edit($id)
    {
        $language_id = 1;
        $post_catalogue = $this->postCatalogueRepository->getPostCatalogueById($id, $language_id);
        $config = $this->config_general();
        $config['seo'] = config('apps.postcatalogue');
        $config['method'] = 'edit';
        $album = json_decode($post_catalogue->album);
        $dropdown = $this->nestedset->Dropdown();
        $template = 'backend.post.catalogue.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'post_catalogue', 'dropdown', 'album'));
    }

    // Update
    public function update(UpdatePostCatalogueRequest $request, $id)
    {
        $update_post_catalogue = $this->postCatalogueService->update($id, $request);

        if ($update_post_catalogue) {
            return redirect()->route('post.catalogue.index')->with('success', 'Cập nhật bản ghi thành công.');
        }

        return redirect()->route('post.catalogue.index')->with('error', 'Cập nhật bản ghi không thành công.');
    }

    // Delete
    public function delete($id)
    {
        $language_id = 1;
        $post_catalogue = $this->postCatalogueRepository->getPostCatalogueById($id, $language_id);
        $config['seo'] = config('apps.postcatalogue');
        $template = 'backend.post.catalogue.delete';
        return view('backend.dashboard.layout', compact('template', 'config', 'post_catalogue'));
    }

    // Destroy
    public function destroy(DeletePostCatalogueRequest $request, $id)
    {
        $delete = $this->postCatalogueService->destroy($id);
        if ($delete) {
            return redirect()->route('post.catalogue.index')->with('success', 'Xoá bản ghi thành công.');
        }

        return redirect()->route('post.catalogue.index')->with('error', 'Xoá bản ghi không thành công.');
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
            'model' => 'PostCatalogue',
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
            'backend/plugins/ckeditor/ckeditor.js',
            'backend/plugins/ckfinder_2/ckfinder.js',
            'backend/library/finder.js',
            'backend/library/seo.js',
        ]);
    }
}
