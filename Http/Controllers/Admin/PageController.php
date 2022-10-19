<?php

namespace Modules\Page\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Contracts\AdminPage;
use Modules\Core\Http\Controllers\FormBuilderController;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Tables\PageTable;
use Omaicode\FormBuilder\Form;

class PageController extends FormBuilderController
{
    protected $request;
    protected array $breadcrumb = [];  
    protected $title = 'Pages';

    public function __construct(Request $request)
    {
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
        $form = new Form(new Page);

        $form->text('name', __('page::messages.name'));
        $form->ckeditor('content', __('page::messages.content'));
        $form->textarea('description', __('page::messages.description'))->rows(2);
        $form->text('seo_title', __('page::messages.seo_title'));
        $form->textarea('seo_description', __('page::messages.seo_description'))->rows(2);

        return $form;
    }
}
