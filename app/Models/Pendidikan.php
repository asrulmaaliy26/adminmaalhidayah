<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;
    protected $table = 'pendidikans';
    protected $fillable = ['pendidikan_name','pendidikan_slug','pendidikan_status'];
    
    public function getArticleCount($where=array())
    {
        return $this->hasMany('App\Models\Article','pendidikan_id','pendidikan_id')
                    ->where($where)
                    ->count();
    }
}
