<?php

namespace App\Http\Controllers\backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
// use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Services\Interfaces\PostServiceInterface as PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    protected $postService;
    protected $postRepository;
    // protected $languageRepository;
    protected $nestedset;

    public function __construct(
        PostService $postService,
        PostRepository $postRepository,
        // LanguageRepository $languageRepository,
    ) {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        // $this->languageRepository = $languageRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1,
        ]);
    }

    // Index
    public function index(Request $request)
    {
        Gate::authorize('modules', 'post.index');
        $posts = $this->postService->paginate($request);
        $config = $this->config();
        $config['seo'] = config('apps.post');
        $template = 'backend.post.post.index';
        $dropdown = $this->nestedset->Dropdown();

        return view('backend.dashboard.layout', compact('template', 'config', 'posts', 'dropdown'));
    }

    // Create
    public function create()
    {
        Gate::authorize('modules', 'post.create');
        $config = $this->config_general();
        $config['seo'] = config('apps.post');
        $config['method'] = 'create';
        $dropdown = $this->nestedset->Dropdown();

        $template = 'backend.post.post.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'dropdown'));
    }

    // Store
    public function store(StorePostRequest $request)
    {
        $new_post = $this->postService->create($request);
        if ($new_post) {
            return redirect()->route('post.index')->with(['success' => 'Thêm mới bản ghi thành công.']);
        }

        return redirect()->route('post.index')->with(['error' => 'Thêm mới bản ghi không thành công.']);
    }

    // Edit
    public function edit($id)
    {
        Gate::authorize('modules', 'post.update');
        $language_id = 1;
        $post = $this->postRepository->getPostById($id, $language_id);
        $config = $this->config_general();
        $config['seo'] = config('apps.post');
        $config['method'] = 'edit';
        $album = json_decode($post->album);
        $dropdown = $this->nestedset->Dropdown();
        $template = 'backend.post.post.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'post', 'dropdown', 'album'));
    }

    // Update
    public function update(UpdatePostRequest $request, $id)
    {
        $update_post = $this->postService->update($id, $request);

        if ($update_post) {
            return redirect()->route('post.index')->with('success', 'Cập nhật bản ghi thành công.');
        }

        return redirect()->route('post.index')->with('error', 'Cập nhật bản ghi không thành công.');
    }

    // Delete
    public function delete($id)
    {
        Gate::authorize('modules', 'post.destroy');
        $language_id = 1;
        $post = $this->postRepository->getPostById($id, $language_id);
        $config['seo'] = config('apps.post');
        $template = 'backend.post.post.delete';
        return view('backend.dashboard.layout', compact('template', 'config', 'post'));
    }

    // Destroy
    public function destroy($id)
    {
        $delete = $this->postService->destroy($id);
        if ($delete) {
            return redirect()->route('post.index')->with('success', 'Xoá bản ghi thành công.');
        }

        return redirect()->route('post.index')->with('error', 'Xoá bản ghi không thành công.');
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
            'model' => 'Post',
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
