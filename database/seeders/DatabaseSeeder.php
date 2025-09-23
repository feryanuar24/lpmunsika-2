<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $categories = [
            [
                'name' => 'Berita',
                'slug' => 'berita',
                'description' => 'Kategori untuk artikel berita',
            ],
            [
                'name' => 'Buletin',
                'slug' => 'buletin',
                'description' => 'Kategori untuk artikel buletin',
            ],
            [
                'name' => 'Karya Mahasiswa',
                'slug' => 'karya-mahasiswa',
                'description' => 'Kategori untuk artikel karya mahasiswa',
            ],
            [
                'name' => 'Resensi Buku',
                'slug' => 'resensi-buku',
                'description' => 'Kategori untuk artikel resensi buku',
            ],
            [
                'name' => 'Review Film',
                'slug' => 'review-film',
                'description' => 'Kategori untuk artikel review film',
            ],
            [
                'name' => 'Opini',
                'slug' => 'opini',
                'description' => 'Kategori untuk artikel opini',
            ],
            [
                'name' => 'Esai',
                'slug' => 'esai',
                'description' => 'Kategori untuk artikel esai',
            ],
            [
                'name' => 'Artikel',
                'slug' => 'article',
                'description' => 'Kategori untuk artikel umum',
            ],
            [
                'name' => 'Puisi',
                'slug' => 'puisi',
                'description' => 'Kategori untuk artikel puisi',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $tags = [
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['name' => 'Teknologi', 'slug' => 'teknologi'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
            ['name' => 'Seni', 'slug' => 'seni'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Musik', 'slug' => 'musik'],
            ['name' => 'Film', 'slug' => 'film'],
            ['name' => 'Literatur', 'slug' => 'literatur'],
            ['name' => 'Sosial', 'slug' => 'sosial'],
            ['name' => 'Politik', 'slug' => 'politik'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
