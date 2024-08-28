<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Jenis;
use App\Models\Pendidikan;
use App\Models\Tingkat;
use App\Models\Page;
use Illuminate\Http\Request;
use stdClass;

class DashboardController extends Controller
{
    public function index()
    {
        $viewData = new stdClass();
        $viewData->articlesTotalView = Article::sum('article_hit');
        $viewData->articlesCount = Article::count();
        $viewData->pageCount = Page::count();
        $viewData->catCount = Category::count();
        $viewData->jeCount = Jenis::count();
        $viewData->penCount = Pendidikan::count();
        $viewData->tingCount = Tingkat::count();
        return view('back.dashboard',compact('viewData'));
    }
}
