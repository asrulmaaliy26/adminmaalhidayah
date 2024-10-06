<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts'; // Nama tabel (default sudah benar)
    
    protected $primaryKey = 'contact_id'; // Kolom primary key yang digunakan

    // Jika primary key bukan auto increment, tambahkan:
    public $incrementing = false;

    // Jika primary key bukan tipe integer, tambahkan:
    protected $keyType = 'string';
    
    use HasFactory;
    protected $fillable=["name","email","pendidikan","subject","message"];
}
