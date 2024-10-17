<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Pendidikan;
use App\Models\Jenis;
use App\Models\Tingkat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    protected $isOnlyUser = false;

    public function __construct()
    {
        $this->middleware(function($request, $next){
            $this->isOnlyUser = Auth::user()->roles->pluck('name')->contains('User');
            return $next($request);
        });
    }

    public function index()
    {
        $articles = Article::latest()->get();
        return view('back.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('back.articles.create', [
            'categories' => Category::all(),
            'jenises' => Jenis::all(),
            'pendidikans' => Pendidikan::all(),
            'tingkats' => Tingkat::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        $data = $this->prepareData($request);
        $data['user_id'] = Auth::id();

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Str::slug($request->title).'_'.date("Ymd_His").'.'.$request->image->getClientOriginalExtension();
            $imagePath = 'uploads/articleimage/';
            $image->move($imagePath,$imageName);
            
            $data['article_image'] = '/'.$imagePath.$imageName;
        }

        $article = Article::create($data);

        return $this->handleRedirect($article, 'created', 'admin.articles.create');
    }

    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        return view('back.articles.update', [
            'categories' => Category::all(),
            'jenises' => Jenis::all(),
            'pendidikans' => Pendidikan::all(),
            'tingkats' => Tingkat::all(),
            'article' => $article,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $this->validateRequest($request);

        $data = $this->prepareData($request);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Str::slug($request->title).'_'.date("Ymd_His").'.'.$request->image->getClientOriginalExtension();
            $imagePath = 'uploads/articleimage/';
            $image->move($imagePath,$imageName);
            $data['article_image'] = '/'.$imagePath.$imageName;

            if (File::exists(public_path($request->oldimage)) && $request->oldimage != '/front/assets/img/home-bg.jpg') 
            {
                unlink(public_path($request->oldimage));
                Session::flash('status', 'File lama telah berhasil dihapus.');
            }
            
        }
        
        if ($request->has('created_at')) {
            $data['created_at'] = $request->created_at; // Update created_at jika ada di request
        }

        $article = Article::where('article_id', $id)->update($data);

        return $this->handleRedirect($article, 'updated', 'admin.articles.edit', $id);
    }

    public function changeStatus($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['article_status' => !$article->article_status]);

        toastr('Article status changed.', 'success', 'Success!');
        return redirect()->route('admin.articles.index');
    }

    public function trashArticle($id)
    {
        $article = $this->findUserArticleOrFail($id);
        $article->delete();

        toastr('Article successfully TRASHED.', 'success', 'Success!');
        return redirect()->route($this->isOnlyUser ? 'admin.articles.myArticles' : 'admin.articles.index');
    }

    public function getTrashedArticles()
    {
        $articles = $this->isOnlyUser
            ? Article::onlyTrashed()->where('user_id', Auth::id())->latest('deleted_at')->get()
            : Article::onlyTrashed()->latest('deleted_at')->get();

        return view('back.articles.trashed', compact('articles'))->with('isOnlyUser', $this->isOnlyUser);
    }

    public function recoverArticle($id)
    {
        Article::onlyTrashed()->where('article_id', $id)->restore();

        toastr('Article successfully RECOVERED.', 'success', 'Success!');
        return redirect()->route('admin.articles.getTrashedArticles');
    }

    public function hardDeleteArticle($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);

        if ($this->isValidImage($article->article_image)) {
            unlink(public_path($article->article_image));
        }

        $article->forceDelete();
        toastr('Article successfully DELETED.', 'success', 'Success!');
        return redirect()->route('admin.articles.getTrashedArticles');
    }

    public function myArticles()
    {
        $articles = Article::where('user_id', Auth::id())->latest()->get();
        return view('back.articles.myArticles', compact('articles'));
    }

    protected function validateRequest(Request $request)
    {
        define('REQUIRED_NOT_SELECTED', 'required|not_in:notSelected');
        $request->validate([
            'title' => 'required',
            'category' => REQUIRED_NOT_SELECTED,
            'jenis' => REQUIRED_NOT_SELECTED,
            'pendidikan' => REQUIRED_NOT_SELECTED,
            'tingkat' => REQUIRED_NOT_SELECTED,
            'image' => 'nullable | mimes:png,jpg,jpeg,webp',
            'content' => 'required'
        ]);
    }

    protected function prepareData(Request $request)
    {
        return [
            'article_title' => $request->title,
            'category_id' => $request->category,
            'jenis_id' => $request->jenis,
            'pendidikan_id' => $request->pendidikan,
            'tingkat_id' => $request->tingkat,
            'article_content' => $request->content,
            'article_slug' => Str::slug($request->title),
            'article_status' => $request->status ? 1 : 0,
        ];
    }

    protected function isValidImage($imagePath)
    {
        return File::exists(public_path($imagePath)) && $imagePath != '/front/assets/img/home-bg.jpg';
    }

    protected function handleRedirect($article, $action, $route, $id = null)
    {
        if ($article) {
            toastr("Article successfully $action.", 'success', 'Success!');
            return redirect()->route($this->isOnlyUser ? 'admin.articles.myArticles' : 'admin.articles.index');
        }

        toastr("Article could not be $action!", 'error', 'Error!');
        return redirect()->route($route, $id);
    }

    protected function findUserArticleOrFail($id)
    {
        $query = Article::where('article_id', $id);
        if ($this->isOnlyUser) {
            $query->where('user_id', Auth::id());
        }

        return $query->firstOrFail();
    }
}