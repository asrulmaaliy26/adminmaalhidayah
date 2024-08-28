<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    
    use SoftDeletes;
    
    protected $fillable=[
        'category_id',
        'jenis_id',
        'pendidikan_id',
        'tingkat_id',
        'user_id',
        'article_title',
        'article_content',
        'article_slug',
        'article_hit',
        'article_status',
        'article_image'
    ];

    protected $table = 'articles'   ;
    protected $primaryKey = 'article_id';

    public function getArticleImageAttribute($value)
    {
        $currentPage = basename($_SERVER['PHP_SELF']);
        return url($value . '?page=' . $currentPage);
    }

    public function getCategory()
    {
        return $this->hasOne('App\Models\Category','category_id','category_id');
    }
    public function getJenis()
    {
        return $this->hasOne('App\Models\Jenis','jenis_id','jenis_id');
    }
    public function getPendidikan()
    {
        return $this->hasOne('App\Models\Pendidikan','pendidikan_id','pendidikan_id');
    }
    public function getTingkat()
    {
        return $this->hasOne('App\Models\Tingkat','tingkat_id','tingkat_id');
    }
    public function getUser()
    {
        return $this->hasOne('App\Models\User','user_id','user_id');
    }
}
