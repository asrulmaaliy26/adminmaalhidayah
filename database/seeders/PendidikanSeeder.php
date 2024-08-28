<?php

namespace Database\Seeders;

use App\Models\Pendidikan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendidikans = ['SD','SMP','SMA','MAHAD','TPQ','KAMPUS'];
        foreach($pendidikans as $pendidikan){
            //DB::table('categories')->insert();
            Pendidikan::create([
                'pendidikan_name' => $pendidikan,
                'pendidikan_slug' => $this->slugify($pendidikan),
            ]);
        }
    }

    private function slugify($text, string $divider = '-')
    {
        // Karakter khusus dalam bahasa Indonesia
        $text = str_replace(
            ['é', 'è', 'ë', 'ó', 'ö', 'ç'], 
            ['e', 'e', 'e', 'o', 'o', 'c'], 
            $text
        );
        
        // Gantikan karakter non-huruf atau digit dengan pembatas
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    
        // Transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
        // Hapus karakter yang tidak diinginkan
        $text = preg_replace('~[^-\w]+~', '', $text);
    
        // Trim pembatas di awal dan akhir
        $text = trim($text, $divider);
    
        // Hapus pembatas yang berulang
        $text = preg_replace('~-+~', $divider, $text);
    
        // Ubah menjadi huruf kecil
        $text = strtolower($text);
    
        if (empty($text)) {
            return 'n-a';
        }
    
        return $text;
    }
}
