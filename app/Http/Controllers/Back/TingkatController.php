<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Tingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redis;

class TingkatController extends Controller
{
    public function index()
    {
        $tingkats = Tingkat::all();
        return view('back.tingkats.index',compact('tingkats'));
    }

    public function changeStatus($id)
    {
        $tingkat = Tingkat::where('tingkat_id',$id)->first();

        $tingkat->where('tingkat_id',$id)->update([
            'tingkat_status' => ($tingkat->tingkat_status == 1 ? 0 : 1)
        ]);
        
        toastr('Tingkat status changed.','success','Success!');

        return redirect()->back();
    }

    public function createTingkat(Request $request)
    {
        Validator::extend('custom_rule_unique_tingkat_slug', function ($attribute, $value, $parameters, $validator) use ($request) {
            // $attribute: Doğrulama yapılacak alanın adı
            // $value: Doğrulama yapılacak alanın değeri
            // $parameters: Doğrulama kuralındaki parametreler (isteğe bağlı)
            // $validator: Validator nesnesi
            $isExits =Tingkat::where('tingkat_slug', Str::slug($request->name))->first();
            if($isExits)
                return false;
            // Doğrulama kurallarını burada kontrol edin
            // Eğer doğruysa true, değilse false döndürün
            return true; // Örnek olarak her zaman true döndürüyoruz
        });
        
        // Şimdi özel doğrulama kuralınızı kullanabilirsiniz:
        $request->validate([
            'name' => 'required|unique:tingkats,tingkat_name|custom_rule_unique_tingkat_slug'
        ],[
            'name.custom_rule_unique_tingkat_slug' => 'This tingkat already exists.',
        ]);

        Tingkat::create([
            'tingkat_name' => Str::title($request->name),
            'tingkat_slug' => Str::slug($request->name),
            'tingkat_status' => $request->status == true ? 1 : 0,
        ]);
        
        toastr('New tingkat CREATED!','success','Success!');

        return redirect()->back();        
    }

    public function getData(Request $request)
    {
        $tingkat = Tingkat::where('tingkat_id',$request->id)->first();
        $tingkat->tingkatList = Tingkat::select('tingkat_id','tingkat_name')->get();
        $tingkat->articleCount = $tingkat->getArticleCount();
        return response()->json($tingkat);
    }

    public function updateTingkat(Request $request)
    {
        Validator::extend('custom_rule_unique_tingkat_slug', function ($attribute, $value, $parameters, $validator) use ($request) {
            // $attribute: Doğrulama yapılacak alanın adı
            // $value: Doğrulama yapılacak alanın değeri
            // $parameters: Doğrulama kuralındaki parametreler (isteğe bağlı)
            // $validator: Validator nesnesi
            $isExits =Tingkat::where(function ($query) use ($request){
                return $query->where('tingkat_id','!=',$request->id)
                            ->where('tingkat_slug', $request->modalSlug)
                            ->orWhere('tingkat_name',$request->modalName);
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
                Rule::unique('tingkats','tingkat_name')->ignore($request->id,'tingkat_id'),
            ],
            'modalSlug' => [
                'required',
                Rule::unique('tingkats','tingkat_slug')->ignore($request->id,'tingkat_id'),
            ],
        ]);

        Tingkat::where('tingkat_id',$request->id)->update([
            'tingkat_name' => $request->modalName,
            'tingkat_slug' => $request->modalSlug,
        ]);
        
        toastr('Tingkat UPDATED!','success','Success!');

        return redirect(route('admin.tingkat.index'));
    }

    public function deleteTingkat(Request $request)
    {
        $articles = Article::where('tingkat_id',$request->deleteId)
                    ->update([
                        'tingkat_id' => $request->newTingkatId
                    ]) ?? abort(403,'Article Update Error!');

        $tingkat = Tingkat::where('tingkat_id','!=',1)
                    ->where('tingkat_id',$request->deleteId)
                    ->delete() ?? abort(403,'Error during tingkat deletion!');

        toastr('Tingkat Successfly DELETED!','success','Success!');
        return redirect()->back();
    }
}
