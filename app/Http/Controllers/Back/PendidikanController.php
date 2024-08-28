<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redis;

class PendidikanController extends Controller
{
    public function index()
    {
        $pendidikans = Pendidikan::all();
        return view('back.pendidikans.index',compact('pendidikans'));
    }

    public function changeStatus($id)
    {
        $pendidikan = Pendidikan::where('pendidikan_id',$id)->first();

        $pendidikan->where('pendidikan_id',$id)->update([
            'pendidikan_status' => ($pendidikan->pendidikan_status == 1 ? 0 : 1)
        ]);
        
        toastr('Pendidikan status changed.','success','Success!');

        return redirect()->back();
    }

    public function createPendidikan(Request $request)
    {
        Validator::extend('custom_rule_unique_pendidikan_slug', function ($attribute, $value, $parameters, $validator) use ($request) {
            // $attribute: Doğrulama yapılacak alanın adı
            // $value: Doğrulama yapılacak alanın değeri
            // $parameters: Doğrulama kuralındaki parametreler (isteğe bağlı)
            // $validator: Validator nesnesi
            $isExits =Pendidikan::where('pendidikan_slug', Str::slug($request->name))->first();
            if($isExits)
                return false;
            // Doğrulama kurallarını burada kontrol edin
            // Eğer doğruysa true, değilse false döndürün
            return true; // Örnek olarak her zaman true döndürüyoruz
        });
        
        // Şimdi özel doğrulama kuralınızı kullanabilirsiniz:
        $request->validate([
            'name' => 'required|unique:pendidikans,pendidikan_name|custom_rule_unique_pendidikan_slug'
        ],[
            'name.custom_rule_unique_pendidikan_slug' => 'This pendidikan already exists.',
        ]);

        Pendidikan::create([
            'pendidikan_name' => Str::title($request->name),
            'pendidikan_slug' => Str::slug($request->name),
            'pendidikan_status' => $request->status == true ? 1 : 0,
        ]);
        
        toastr('New pendidikan CREATED!','success','Success!');

        return redirect()->back();        
    }

    public function getData(Request $request)
    {
        $pendidikan = Pendidikan::where('pendidikan_id',$request->id)->first();
        $pendidikan->pendidikanList = Pendidikan::select('pendidikan_id','pendidikan_name')->get();
        $pendidikan->articleCount = $pendidikan->getArticleCount();
        return response()->json($pendidikan);
    }

    public function updatePendidikan(Request $request)
    {
        Validator::extend('custom_rule_unique_pendidikan_slug', function ($attribute, $value, $parameters, $validator) use ($request) {
            // $attribute: Doğrulama yapılacak alanın adı
            // $value: Doğrulama yapılacak alanın değeri
            // $parameters: Doğrulama kuralındaki parametreler (isteğe bağlı)
            // $validator: Validator nesnesi
            $isExits =Pendidikan::where(function ($query) use ($request){
                return $query->where('pendidikan_id','!=',$request->id)
                            ->where('pendidikan_slug', $request->modalSlug)
                            ->orWhere('pendidikan_name',$request->modalName);
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
                Rule::unique('pendidikans','pendidikan_name')->ignore($request->id,'pendidikan_id'),
            ],
            'modalSlug' => [
                'required',
                Rule::unique('pendidikans','pendidikan_slug')->ignore($request->id,'pendidikan_id'),
            ],
        ]);

        Pendidikan::where('pendidikan_id',$request->id)->update([
            'pendidikan_name' => $request->modalName,
            'pendidikan_slug' => $request->modalSlug,
        ]);
        
        toastr('Pendidikan UPDATED!','success','Success!');

        return redirect(route('admin.pendidikan.index'));
    }

    public function deletePendidikan(Request $request)
    {
        $articles = Article::where('pendidikan_id',$request->deleteId)
                    ->update([
                        'pendidikan_id' => $request->newPendidikanId
                    ]) ?? abort(403,'Article Update Error!');

        $pendidikan = Pendidikan::where('pendidikan_id','!=',1)
                    ->where('pendidikan_id',$request->deleteId)
                    ->delete() ?? abort(403,'Error during pendidikan deletion!');

        toastr('Pendidikan Successfly DELETED!','success','Success!');
        return redirect()->back();
    }
}
