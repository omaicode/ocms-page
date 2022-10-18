<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PageController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('theme:'.config('appearance.currentTheme'));
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($slug = null)
    {
        return view('layout');
    }
}
