<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Repositories\CategoryRepository;
use Modules\Page\Enums\PageStatusEnum;
use Modules\Page\Enums\PageTemplateEnum;
use Modules\Page\Repositories\PageRepository;
use Omaicode\Modules\Facades\Module;

class PageController extends Controller
{
    protected $request;
    protected $repository;

    public function __construct(Request $request, PageRepository $repository)
    {
        $this->middleware('theme:'.config('appearance.currentTheme'));
        $this->request = $request;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($slug = null)
    {
        $view = 'home';
        $data = [];

        if(!$slug) {
            $home_page = $this->repository->findWhere([
                'template' => PageTemplateEnum::HOME,
                'status'   => PageStatusEnum::PUBLISH
            ]);

            if($home_page->count() > 0) {
                $view = 'home';
                $data = $home_page->first();
            }
        } else {
            $page = $this->repository->findWhere([
                'slug'    => $slug,
                'status' => PageStatusEnum::PUBLISH
            ]);

            if($page->count() > 0) {
                $view = strtolower(PageTemplateEnum::getKey((int)$page->first()->template));
                $data = $page->first();
            } else if(Module::has('Blog') && Module::isEnabled('Blog')) {
                $post = app(\Modules\Blog\Repositories\PostRepository::class)->with('category')->findByField('slug', $slug);
                if($post->count() > 0) {
                    $view = 'post';
                    $data = $post->first();
                } else {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        }
                
        return view($view, $data)->withShortcodes();
    }
}
