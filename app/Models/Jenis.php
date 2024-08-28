<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;
    protected $table = 'jenises';
    protected $fillable = ['jenis_name','jenis_slug','jenis_status'];
    
    public function getArticleCount($where=array())
    {
        return $this->hasMany('App\Models\Article','jenis_id','jenis_id')
                    ->where($where)
                    ->count();
    }
}
