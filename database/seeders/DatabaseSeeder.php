<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Footer;
use App\Models\Menu;
use App\Models\Platform;
use App\Models\Slider;
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
                'slug' => 'artikel',
                'description' => 'Kategori untuk artikel umum',
            ],
            [
                'name' => 'Puisi',
                'slug' => 'puisi',
                'description' => 'Kategori untuk artikel puisi',
            ],
            [
                'name' => 'Cerpen',
                'slug' => 'cerpen',
                'description' => 'Kategori untuk artikel cerpen',
            ],
            [
                'name' => 'Gaya Mahasiswa',
                'slug' => 'gaya-mahasiswa',
                'description' => 'Kategori untuk gaya mahasiswa'
            ],
            [
                'name' => 'Produk',
                'slug' => 'produk',
                'description' => 'Kategori parent untuk buletin dan majalah'
            ],
            [
                'name' => 'Majalah',
                'slug' => 'majalah',
                'description' => 'Kategori untuk artikel majalah'
            ]
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

        $platforms = [
            [

                'name' => 'Youtube',
                'url' => 'https://youtube.com/@lpmunsika',
                'icon' => 'ki-youtube',
                'description' => 'Platform resmi LPM Unsika di Youtube',
            ],
            [
                'name' => 'Spotify',
                'url' => 'https://open.spotify.com/show/3PSxdzFHQz77vVRZfxBRdS',
                'icon' => 'ki-spotify',
                'description' => 'Platform resmi LPM Unsika di Spotify',
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://instagram.com/lpmunsika',
                'icon' => 'ki-instagram',
                'description' => 'Platform resmi LPM Unsika di Instagram',
            ],
            [
                'name' => 'Twitter',
                'url' => 'https://twitter.com/lpmunsika',
                'icon' => 'ki-twitter',
                'description' => 'Platform resmi LPM Unsika di Twitter',
            ],
            [
                'name' => 'Facebook',
                'url' => 'https://facebook.com/lpmunsika',
                'icon' => 'ki-facebook',
                'description' => 'Platform resmi LPM Unsika di Facebook',
            ],
            [
                'name' => 'LinkedIn',
                'url' => 'https://id.linkedin.com/company/lembaga-pers-mahasiswa-unsika',
                'icon' => 'ki-social-media',
                'description' => 'Platform resmi LPM Unsika di LinkedIn',
            ],
            [
                'name' => 'TikTok',
                'url' => 'https://www.tiktok.com/@lpmunsika',
                'icon' => 'ki-tiktok',
                'description' => 'Platform resmi LPM Unsika di TikTok',
            ]
        ];

        foreach ($platforms as $platform) {
            Platform::create($platform);
        }

        $sliders = [
            [
                'name' => 'Banner 1',
                'banner' => 'assets/media/images/2600x1200/1.png',
                'description' => 'Gambar 1'
            ],
            [
                'name' => 'Banner 2',
                'banner' => 'assets/media/images/2600x1200/2.png',
                'description' => 'Gambar 2'
            ],
            [
                'name' => 'Banner 3',
                'banner' => 'assets/media/images/2600x1200/2.png',
                'description' => 'Gambar 3'
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }

        $menus = [
            [
                'parent_id' => null,
                'name' => 'Dashboard',
                'url' => '/dashboard',
                'icon' => 'ki-graph',
                'description' => 'Halaman utama dashboard'
            ],
            [
                'parent_id' => null,
                'name' => 'Manajemen Pengguna',
                'url' => null,
                'icon' => null,
                'description' => 'Menu parent untuk manajemen pengguna'
            ],
            [
                'parent_id' => 2,
                'name' => 'Profil',
                'url' => '/profile',
                'icon' => 'ki-user',
                'description' => 'Halaman untuk melihat profil pengguna'
            ],
            [
                'parent_id' => 2,
                'name' => 'Pengguna',
                'url' => '/users',
                'icon' => 'ki-users',
                'description' => 'Halaman untuk melihat daftar pengguna'
            ],
            [
                'parent_id' => null,
                'name' => 'Manajemen Konten',
                'url' => null,
                'icon' => null,
                'description' => 'Menu parent untuk manajemen konten'
            ],
            [
                'parent_id' => 5,
                'name' => 'Artikel',
                'url' => '/articles',
                'icon' => 'ki-document',
                'description' => 'Halaman untuk manajemen artikel'
            ],
            [
                'parent_id' => 5,
                'name' => 'Kategori',
                'url' => '/categories',
                'icon' => 'ki-category',
                'description' => 'Halaman untuk manajemen kategori'
            ],
            [
                'parent_id' => 5,
                'name' => 'Tag',
                'url' => '/tags',
                'icon' => 'ki-tag',
                'description' => 'Halaman untuk manajemen tag'
            ],
            [
                'parent_id' => null,
                'name' => 'Manajemen Widget',
                'url' => null,
                'icon' => null,
                'description' => 'Menu parent untuk manajemen widget'
            ],
            [
                'parent_id' => 9,
                'name' => 'Platform',
                'url' => '/platforms',
                'icon' => 'ki-social-media',
                'description' => 'Halaman untuk manajemen platform'
            ],
            [
                'parent_id' => 9,
                'name' => 'Embed',
                'url' => '/embeds',
                'icon' => 'ki-fasten',
                'description' => 'Halaman untuk manajemen embed'
            ],
            [
                'parent_id' => 9,
                'name' => 'Sliders',
                'url' => '/sliders',
                'icon' => 'ki-slider',
                'description' => 'Halaman untuk manajemen sliders'
            ],
            [
                'parent_id' => null,
                'name' => 'Pengaturan',
                'url' => null,
                'icon' => null,
                'description' => 'Menu parent untuk pengaturan sistem'
            ],
            [
                'parent_id' => 13,
                'name' => 'Permissions',
                'url' => '/permissions',
                'icon' => 'ki-lock',
                'description' => 'Halaman untuk manajemen permissions'
            ],
            [
                'parent_id' => 13,
                'name' => 'Roles',
                'url' => '/roles',
                'icon' => 'ki-key',
                'description' => 'Halaman untuk manajemen roles'
            ],
            [
                'parent_id' => 13,
                'name' => 'Permission Role',
                'url' => '/permission-role',
                'icon' => 'ki-shield',
                'description' => 'Halaman untuk manajemen permission role'
            ],
            [
                'parent_id' => 9,
                'name' => 'Footer',
                'url' => '/footers',
                'icon' => 'ki-tablet-text-down',
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        $footers = [
            [
                'name' => 'Profil',
                'url' => 'https://youtu.be/0jd3CjEjeaY?si=QQoi3eNwv_AZzgRG',
                'description' => 'Video profil LPM Unsika'
            ],
            [
                'name' => 'Rekrutmen',
                'url' => 'https://bit.ly/RekrutmenTerbukaLPMUnsikaTahun2025',
                'description' => 'Formulir rekrutmen LPM Unsika'
            ],
            [
                'name' => 'Buletin 38',
                'url' => 'https://lpmunsika.com/detail/buletin-suara-unsika-edisi-38',
                'description' => 'Buletin Suara Unsika Edisi 38'
            ],
            [
                'name' => 'Kontributor',
                'url' => 'https://bit.ly/LPMUNSIKA',
                'description' => 'Bergabung menjadi kontributor LPM Unsika'
            ]
        ];

        foreach ($footers as $footer) {
            Footer::create($footer);
        }
    }
}
