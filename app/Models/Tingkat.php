<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    use HasFactory;
    protected $table = 'tingkats';
    protected $fillable = ['tingkat_name','tingkat_slug','tingkat_status'];
    
    public function getArticleCount($where=array())
    {
        return $this->hasMany('App\Models\Article','tingkat_id','tingkat_id')
                    ->where($where)
                    ->count();
    }
}
