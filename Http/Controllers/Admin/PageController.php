<?php

namespace Modules\Page\Http\Controllers\Admin;

use ApiResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Contracts\AdminPage;
use Modules\Core\Http\Controllers\FormBuilderController;
use Modules\Page\Entities\Page;
use Modules\Page\Enums\PageStatusEnum;
use Modules\Page\Enums\PageTemplateEnum;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Tables\PageTable;
use Modules\Form\Form;
use Modules\Form\Tools;

class PageController extends FormBuilderController
{
    protected $request;
    protected array $breadcrumb = [];  
    protected $title = 'Pages';

    public function __construct(Request $request)
    {
        $this->middleware('can:page.view', ['index']);
        $this->middleware('can:page.edit', ['edit', 'update']);
        $this->middleware('can:page.create', ['create', 'store']);
        $this->middleware('can:page.delete', ['deletes']);

        $this->request = $request;
        $this->breadcrumb[] = [
            'title'  => __('page::messages.pages'), 
            'url'    => route('admin.pages.index'),
        ];
    }

    protected function index()
    {        
        return app(AdminPage::class)
        ->title('page::messages.pages')
        ->breadcrumb($this->breadcrumb)
        ->body(new PageTable);
    }

    protected function form()
    {
        $statuses = PageStatusEnum::asSelectArray();
        $templates = PageTemplateEnum::asSelectArray();
        $form = new Form(new Page);

        $form->slug('name', 'slug', __('page::messages.name'))
              ->creationRules('required|unique:pages,slug')
              ->updateRules('required|unique:pages,slug,{{id}},id');
        $form->quillEditor('content', __('page::messages.content'));
        $form->text('seo_title', __('page::messages.seo_title'));
        $form->textarea('seo_description', __('page::messages.seo_description'))->rows(2);

        $form->tools(function(Tools $tool) use ($statuses, $templates) {
            $tool->select('status', __('page::messages.status'))->options($statuses)->default(PageStatusEnum::DRAFT);
            $tool->select('template', __('page::messages.template'))->options($templates)->default(PageTemplateEnum::DEFAULT);
            $tool->media('featured_image', __('page::messages.featured_image'), Page::class)->placeholder(__('page::messages.select_featured_image'));
        });

        return $form;
    }


    public function deletes()
    {
        $rows = $this->request->rows;
        Page::whereIn('id', $rows)->delete();

        return ApiResponse::success();
    }    
}
