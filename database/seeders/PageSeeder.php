<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = ['About','Career','Vision','Mission'];
        $count = 0;
        foreach($pages as $page){
            Page::create([
                'page_title' => $page,
                'page_image' => '/front/assets/img/about-bg.jpg',
                'page_content' => $page. ' Page. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas optio, tenetur ex velit eius harum vitae architecto, sapiente repellat accusamus reprehenderit excepturi inventore itaque dignissimos. Nam sint enim numquam molestiae.',
                'page_slug' => $this->slugify($page),
                'page_order' => ++$count
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
