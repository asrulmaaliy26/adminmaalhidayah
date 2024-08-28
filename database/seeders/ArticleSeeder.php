<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lorem = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
         venenatis at mi at bibendum. Integer congue odio mi, sed porta nibh ornare id. 
         Aenean enim odio, vehicula sit amet accumsan eget, hendrerit sed tortor. 
         In semper quam sed diam blandit, eget suscipit nibh lobortis. Cras tincidunt 
         nisl eget viverra laoreet. Ut porttitor mauris eget porta cursus. Nunc volutpat 
         tincidunt fringilla.</p>
         <p>Phasellus fringilla sollicitudin erat, vitae finibus ipsum ullamcorper eget. 
         Vivamus imperdiet rhoncus imperdiet. Cras euismod magna ac velit varius, in hendrerit
         turpis hendrerit. Nunc justo purus, convallis ac lacinia ac, vehicula ac metus. In 
         semper feugiat diam a sodales. Donec semper fermentum feugiat. Praesent nec libero 
         tempor, mattis felis id, maximus metus. Aliquam varius orci sed arcu consectetur 
         ultrices. Sed non varius nisi, sed ornare nisl. Nunc accumsan velit eu convallis 
         ultrices. Sed vestibulum posuere ipsum, nec condimentum nulla aliquet molestie. 
         Vestibulum pharetra urna ut molestie laoreet. Donec viverra vestibulum odio, vel 
         varius est suscipit id.</p>
         <p>Ut tempus neque mi, eget molestie libero consequat ac. Integer blandit justo nec
         lacus varius, et pulvinar mi gravida. Vivamus non sodales quam. Aenean non risus 
         quis sem commodo ultricies in eu libero. Donec imperdiet imperdiet tincidunt. Mauris
          id consectetur ligula. Pellentesque habitant morbi tristique senectus et netus et 
          malesuada fames ac turpis egestas.</p>
        ';

        $datas = [
            [
                'category_id' =>2,
                'jenis_id' =>2,
                'tingkat_id' =>2,
                'pendidikan_id' =>2,
                'user_id' => 1,
                'article_title'=>'lorem3',
                'article_content' => $lorem,
                'article_slug' => $this->slugify('Merhaba Dünya'),
                'article_image' => 'https://picsum.photos/id/237/1920/1080',
                'article_status' => 1,
                'created_at' => now()
            ],
            [
                'category_id' =>1,
                'jenis_id' =>2,
                'tingkat_id' =>2,
                'pendidikan_id' =>2,
                'user_id' => 2,
                'article_title'=>'lorem2',
                'article_content' => $lorem,
                'article_slug' => $this->slugify('Ford Yeni Araba'),
                'article_image' => 'https://picsum.photos/id/238/1920/1080',
                'article_status' => 1,
                'created_at' => date("2024-02-04 12:30:00")
            ],
            [
                'category_id' =>3,
                'jenis_id' =>2,
                'tingkat_id' =>2,
                'pendidikan_id' =>2,
                'user_id' => 3,
                'article_title'=>'lorem1?',
                'article_content' => $lorem,
                'article_slug' => $this->slugify('lorem1?'),
                'article_image' => 'https://picsum.photos/id/239/1920/1080',
                'article_status' => 1,
                'created_at' => date("2024-02-04 16:30:00")
            ],
        ];
        foreach($datas as $data)
            Article::create($data);
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


    private function loremIpsum()
    {
        return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque venenatis at mi at bibendum. Integer congue odio mi, sed porta nibh ornare id. Aenean enim odio, vehicula sit amet accumsan eget, hendrerit sed tortor. In semper quam sed diam blandit, eget suscipit nibh lobortis. Cras tincidunt nisl eget viverra laoreet. Ut porttitor mauris eget porta cursus. Nunc volutpat tincidunt fringilla.

        Phasellus fringilla sollicitudin erat, vitae finibus ipsum ullamcorper eget. Vivamus imperdiet rhoncus imperdiet. Cras euismod magna ac velit varius, in hendrerit turpis hendrerit. Nunc justo purus, convallis ac lacinia ac, vehicula ac metus. In semper feugiat diam a sodales. Donec semper fermentum feugiat. Praesent nec libero tempor, mattis felis id, maximus metus. Aliquam varius orci sed arcu consectetur ultrices. Sed non varius nisi, sed ornare nisl. Nunc accumsan velit eu convallis ultrices. Sed vestibulum posuere ipsum, nec condimentum nulla aliquet molestie. Vestibulum pharetra urna ut molestie laoreet. Donec viverra vestibulum odio, vel varius est suscipit id.
        
        Ut tempus neque mi, eget molestie libero consequat ac. Integer blandit justo nec lacus varius, et pulvinar mi gravida. Vivamus non sodales quam. Aenean non risus quis sem commodo ultricies in eu libero. Donec imperdiet imperdiet tincidunt. Mauris id consectetur ligula. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.';
    }
}
