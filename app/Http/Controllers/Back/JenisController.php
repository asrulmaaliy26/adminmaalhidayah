<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redis;

class JenisController extends Controller
{
    public function index()
    {
        $jenises = Jenis::all();
        return view('back.jenises.index',compact('jenises'));
    }

    public function changeStatus($id)
    {
        $jenis = Jenis::where('jenis_id',$id)->first();

        $jenis->where('jenis_id',$id)->update([
            'jenis_status' => ($jenis->jenis_status == 1 ? 0 : 1)
        ]);
        
        toastr('Jenis status changed.','success','Success!');

        return redirect()->back();
    }

    public function createJenis(Request $request)
    {
        Validator::extend('custom_rule_unique_jenis_slug', function ($attribute, $value, $parameters, $validator) use ($request) {
            // $attribute: Doğrulama yapılacak alanın adı
            // $value: Doğrulama yapılacak alanın değeri
            // $parameters: Doğrulama kuralındaki parametreler (isteğe bağlı)
            // $validator: Validator nesnesi
            $isExits =Jenis::where('jenis_slug', Str::slug($request->name))->first();
            if($isExits)
                return false;
            // Doğrulama kurallarını burada kontrol edin
            // Eğer doğruysa true, değilse false döndürün
            return true; // Örnek olarak her zaman true döndürüyoruz
        });
        
        // Şimdi özel doğrulama kuralınızı kullanabilirsiniz:
        $request->validate([
            'name' => 'required|unique:jenises,jenis_name|custom_rule_unique_jenis_slug'
        ],[
            'name.custom_rule_unique_jenis_slug' => 'This jenis already exists.',
        ]);

        Jenis::create([
            'jenis_name' => Str::title($request->name),
            'jenis_slug' => Str::slug($request->name),
            'jenis_status' => $request->status == true ? 1 : 0,
        ]);
        
        toastr('New jenis CREATED!','success','Success!');

        return redirect()->back();        
    }

    public function getData(Request $request)
    {
        $jenis = Jenis::where('jenis_id',$request->id)->first();
        $jenis->jenisList = Jenis::select('jenis_id','jenis_name')->get();
        $jenis->articleCount = $jenis->getArticleCount();
        return response()->json($jenis);
    }

    public function updateJenis(Request $request)
    {
        Validator::extend('custom_rule_unique_jenis_slug', function ($attribute, $value, $parameters, $validator) use ($request) {
            // $attribute: Doğrulama yapılacak alanın adı
            // $value: Doğrulama yapılacak alanın değeri
            // $parameters: Doğrulama kuralındaki parametreler (isteğe bağlı)
            // $validator: Validator nesnesi
            $isExits =Jenis::where(function ($query) use ($request){
                return $query->where('jenis_id','!=',$request->id)
                            ->where('jenis_slug', $request->modalSlug)
                            ->orWhere('jenis_name',$request->modalName);
            })->first();
            if($isExits)
                return false;
            // Doğrulama kurallarını burada kontrol edin
            // Eğer doğruysa true, değilse false döndürün
            return true; // Örnek olarak her zaman true döndürüyoruz
        });
        
        // Şimdi özel doğrulama kuralınızı kullanabilirsiniz:
        $request->validate([
            'modalName' => [
                'required',
                Rule::unique('jenises','jenis_name')->ignore($request->id,'jenis_id'),
            ],
            'modalSlug' => [
                'required',
                Rule::unique('jenises','jenis_slug')->ignore($request->id,'jenis_id'),
            ],
        ]);

        Jenis::where('jenis_id',$request->id)->update([
            'jenis_name' => $request->modalName,
            'jenis_slug' => $request->modalSlug,
        ]);
        
        toastr('Jenis UPDATED!','success','Success!');

        return redirect(route('admin.jenis.index'));
    }

    public function deleteJenis(Request $request)
    {
        $articles = Article::where('jenis_id',$request->deleteId)
                    ->update([
                        'jenis_id' => $request->newJenisId
                    ]) ?? abort(403,'Article Update Error!');

        $jenis = Jenis::where('jenis_id','!=',1)
                    ->where('jenis_id',$request->deleteId)
                    ->delete() ?? abort(403,'Error during jenis deletion!');

        toastr('Jenis Successfly DELETED!','success','Success!');
        return redirect()->back();
    }
}
