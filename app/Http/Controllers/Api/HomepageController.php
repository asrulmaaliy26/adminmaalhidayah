<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Jenis;
use App\Models\Pendidikan;
use App\Models\Tingkat;
use App\Models\Page;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class HomepageController extends Controller
{

    public function index()
    {
        $articles = Article::where('article_status', 1)
                        ->orderBy('article_id', 'desc')
                        ->get();
        return response()->json($articles);
    }

    public function getArticlesPaginasi($total)
    {
        $articles = Article::where('article_status', 1)
                        ->orderBy('article_id', 'desc')
                        ->paginate($total); // Mengatur jumlah artikel per halaman
        
        return response()->json($articles);
    }

    public function getOneArticle($slug)
    {
        $article = Article::where(['article_id' => $slug, 'article_status' => 1])
                        ->first(); // Menghapus orderBy karena tidak diperlukan

        if (!$article) {
            return response()->json(['error' => 'Article not found'], 403);
        }

        $article->update(['article_hit' => $article->article_hit + 1]);

        return response()->json($article);
    }


    public function getOneCategory($id)
    {
        $category = Category::where(['category_id' => $id, 'category_status' => 1])
                        ->first(); // Menghapus orderBy karena tidak diperlukan

        if (!$category) {
            return response()->json(['error' => 'category not found'], 403);
        }

        return response()->json($category);
    }

    public function getCategory()
    {
        $categories = Category::where('category_status', 1)->get();

        return response()->json($categories);
    }

    public function getOneJenis($id)
    {
        $jenis = Jenis::where(['jenis_id' => $id, 'jenis_status' => 1])
                        ->first(); // Menghapus orderBy karena tidak diperlukan

        if (!$jenis) {
            return response()->json(['error' => 'jenis not found'], 403);
        }

        return response()->json($jenis);
    }

    public function getJenis()
    {
        $jenises = Jenis::where('jenis_status', 1)->get();

        return response()->json($jenises);
    }

    public function getOnePendidikan($id)
    {
        $pendidikan = Pendidikan::where(['pendidikan_id' => $id, 'pendidikan_status' => 1])
                        ->first(); // Menghapus orderBy karena tidak diperlukan

        if (!$pendidikan) {
            return response()->json(['error' => 'pendidikan not found'], 403);
        }

        return response()->json($pendidikan);
    }

    public function getPendidikan()
    {
        $pendidikans = Pendidikan::where('pendidikan_status', 1)->get();

        return response()->json($pendidikans);
    }

    public function getOneTingkat($id)
    {
        $tingkat = Tingkat::where(['tingkat_id' => $id, 'tingkat_status' => 1])
                        ->first(); // Menghapus orderBy karena tidak diperlukan

        if (!$tingkat) {
            return response()->json(['error' => 'tingkat not found'], 403);
        }

        return response()->json($tingkat);
    }

    public function getTingkat()
    {
        $tingkats = Tingkat::where('tingkat_status', 1)->get();

        return response()->json($tingkats);
    }

    public function getArticleByOneTypes($type, $typeSlug)
    {
        $articles = Article::where("{$type}_id", $typeSlug)
                           ->where('article_status', 1)
                           ->orderBy('article_id', 'desc')
                           ->get();

        if ($articles->isEmpty()) {
            return response()->json(['error' => 'No articles found for the given types'], 403);
        }

        return response()->json($articles);
    }

    public function getArticleByTwoTypes($type1, $type1Slug, $type2, $type2Slug)
    {
        $articles = Article::where("{$type1}_id", $type1Slug)
                           ->where("{$type2}_id", $type2Slug)
                           ->where('article_status', 1)
                           ->orderBy('article_id', 'desc')
                           ->get();

        if ($articles->isEmpty()) {
            return response()->json(['error' => 'No articles found for the given types'], 403);
        }

        return response()->json($articles);
    }

    public function getArticleByThreeTypes($type1, $type1Slug, $type2, $type2Slug, $type3, $type3Slug)
    {
        $articles = Article::where("{$type1}_id", $type1Slug)
                           ->where("{$type2}_id", $type2Slug)
                           ->where("{$type3}_id", $type3Slug)
                           ->where('article_status', 1)
                           ->orderBy('article_id', 'desc')
                           ->get();

        if ($articles->isEmpty()) {
            return response()->json(['error' => '-'], 403);
        }

        return response()->json($articles);
    }

    public function getArticleByFourTypes($type1, $type1Slug, $type2, $type2Slug, $type3, $type3Slug, $type4, $type4Slug)
    {
        $articles = Article::where("{$type1}_slug", $type1Slug)
                           ->where("{$type2}_slug", $type2Slug)
                           ->where("{$type3}_slug", $type3Slug)
                           ->where("{$type4}_slug", $type4Slug)
                           ->where('article_status', 1)
                           ->orderBy('article_id', 'desc')
                           ->get();

        if ($articles->isEmpty()) {
            return response()->json(['error' => 'No articles found for the given types'], 403);
        }

        return response()->json($articles);
    }

    public function page($slug)
    {
        $page = Page::where(['page_slug' => $slug, 'page_status' => 1])->first();

        if (!$page) {
            return response()->json(['error' => 'Page not found'], 403);
        }

        return response()->json($page);
    }

    public function getContact()
    {
        $contacts = Contact::all();

        // Kembalikan data dalam bentuk JSON
        return response()->json([
            'status' => 'success',
            'contacts' => $contacts
        ]);
    }

    public function postContact(Request $request)
    {
        $request->validate([
            "name" => 'required',
            "email" => 'required|email',
            'subject' => 'required|not_in:notSelected',
            'message' => 'required'
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->pendidikan = $request->pendidikan;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        return response()->json($request->all());
    }
}
