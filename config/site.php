<?php

/*
|--------------------------------------------------------------------------
| SMILJAN SOUTHSPARE — Site content
|--------------------------------------------------------------------------
|
| Single source of truth for all content rendered on the landing page.
| Swap in real photography, menu data, journal entries, events and links
| from your CMS / backend without touching any Blade template.
|
*/

return [

    'brand' => [
        'name' => 'SMILJAN',
        'sub' => 'SOUTHSPARE',
        'area' => 'CIPETE / JAKARTA',
        'coords' => '06° SOUTH / 106° EAST',
        'manifesto' => 'KOPI / BUKU / ORANG / JAKARTA SELATAN',
    ],

    'address' => [
        'lines' => [
            'Jl. BDN 1',
            'Cilandak Barat',
            'Jakarta Selatan',
        ],
        'maps_url' => 'https://www.google.com/maps/place/Smiljan+Southspare/@-6.279791,106.7989644,17z/data=!3m1!4b1!4m6!3m5!1s0x2e69f100033e3b7d:0xd7296777ad54c268!8m2!3d-6.279791!4d106.7963895',
    ],

    'hours' => [
        'open' => '08:00',
        'close' => '22:00',
        'timezone' => 'Asia/Jakarta',
    ],

    'nav' => [
        'items' => [
            ['label' => 'Ruang',      'href' => '#ruang'],
            ['label' => 'Kopi',       'href' => '#kopi'],
            ['label' => 'Jurnal',     'href' => '#jurnal'],
            ['label' => 'Kunjungi',   'href' => '#kunjungi'],
        ],
    ],

    'social' => [
        'instagram' => 'https://www.instagram.com/',
        'maps' => 'https://www.google.com/maps/place/Smiljan+Southspare/@-6.279791,106.7989644,17z/data=!3m1!4b1!4m6!3m5!1s0x2e69f100033e3b7d:0xd7296777ad54c268!8m2!3d-6.279791!4d106.7963895',
        'contact' => 'mailto:halo@smiljan.southspare',
    ],

    'hero' => [
        'eyebrow' => 'SMILJAN / SOUTHSPARE',
        'label' => 'KOPI · BUKU · RUANG · KOMUNITAS',
        'lines' => ['KOPI,', 'BUKU &', 'HARI YANG', 'LEBIH PELAN.'],
        'copy' => 'Kopi, percakapan dan sudut tenang di selatan Jakarta.',
        'scroll' => 'GULIR UNTUK BERJALAN-JALAN',
        'image' => [
            'src' => '/images/hero-cafe.webp',
            'alt' => 'Suasana hangat di dalam ruang Smiljan Southspare',
        ],
        'mono' => 'OPEN DAILY / 08—22',
    ],

    'manifesto' => [
        'index' => '01',
        'label' => 'FILOSOFI',
        'en' => 'PHILOSOPHY',
        'title' => ['Bukan sekadar', 'tempat untuk', 'minum kopi.'],
        'copy' => 'Ruang untuk membaca, bekerja, berpikir, bertemu — dan kadang, tak melakukan apa-apa.',
        'accent' => [
            'id' => 'tinggal sebentar.',
            'en' => 'STAY A WHILE.',
        ],
    ],

    'space' => [
        'index' => '02',
        'label' => 'RUANG',
        'en' => 'THE SPACE',
        'title' => ['Ruang yang', 'sengaja dibuat', 'pelan.'],
        'copy' => 'Arsitektur dan interior yang dirancang untuk ditinggali — meja komunal, rak buku dari lantai ke langit-langit, dan cahaya yang jatuh dengan sendirinya.',
        'items' => [
            [
                'n' => '01',
                'caption' => 'BACA',
                'en' => 'READ',
                'src' => '/images/space-bookshelf.webp',
                'alt' => 'Rak buku besar dari lantai hingga langit-langit',
            ],
            [
                'n' => '02',
                'caption' => 'KERJA',
                'en' => 'WORK',
                'src' => '/images/space-architecture.webp',
                'alt' => 'Detail arsitektur beton dan cahaya',
            ],
            [
                'n' => '03',
                'caption' => 'NGAOBROL',
                'en' => 'TALK',
                'src' => '/images/community-people.webp',
                'alt' => 'Orang-orang duduk dan mengobrol di meja panjang',
            ],
            [
                'n' => '04',
                'caption' => 'BERHENTI',
                'en' => 'PAUSE',
                'src' => '/images/space-detail.webp',
                'alt' => 'Detail kopi hangat di atas meja kayu',
            ],
        ],
    ],

    'coffee' => [
        'index' => '03',
        'label' => 'MENU',
        'en' => 'COFFEE',
        'title' => ['KOPI,', 'TANPA', 'KERAMAIN.'],
        'copy' => 'Pilihan ringkas. Diseduh dengan teliti, disajikan dengan tenang.',
        'categories' => [
            [
                'name' => 'ESPRESSO',
                'note' => 'Singkat dan langsung',
                'items' => [
                    ['name' => 'Espresso',        'desc' => 'Satu gelas kecil yang berisi banyak hal.', 'price' => 28000],
                    ['name' => 'Macchiato',       'desc' => 'Espresso dengan sedikit busa susu.',       'price' => 32000],
                    ['name' => 'Long Black',      'desc' => 'Espresso dengan air panas.',               'price' => 33000],
                ],
            ],
            [
                'name' => 'FILTER',
                'note' => 'Pelan dan bersih',
                'items' => [
                    ['name' => 'V60',             'desc' => 'Diseduh perlahan, satu cangkir demi satu.', 'price' => 38000],
                    ['name' => 'Aeropress',       'desc' => 'Rasa bersih, mudah dinikmati.',             'price' => 36000],
                    ['name' => 'Cold Brew',       'desc' => 'Duduk lama, diseduh lebih lama.',           'price' => 40000],
                ],
            ],
            [
                'name' => 'MILK',
                'note' => 'Lembut dan ramah',
                'items' => [
                    ['name' => 'Flat White',      'desc' => 'Susu halus, kopi yang tenang.',             'price' => 42000],
                    ['name' => 'Cappuccino',      'desc' => 'Klasik dengan busa lembut.',                'price' => 42000],
                    ['name' => 'Latte',           'desc' => 'Untuk pagi yang pelan.',                    'price' => 43000],
                ],
            ],
            [
                'name' => 'SEASONAL',
                'note' => 'Mengikuti musim',
                'items' => [
                    ['name' => 'Kopi Nusantara',  'desc' => 'Cerita dari kebun di negeri sendiri.',      'price' => 45000],
                    ['name' => 'Rotasi Musiman',  'desc' => 'Mengikuti apa yang sedang bagus.',          'price' => 45000],
                ],
            ],
        ],
        'image' => [
            'src' => '/images/coffee-filter.webp',
            'alt' => 'Proses menyeduh kopi filter dengan teliti',
        ],
    ],

    'coffee_philosophy' => [
        'quote' => 'Kopi yang baik tak perlu banyak penjelasan.',
        'sub' => 'Diseduh dengan teliti. Disajikan dengan tenang.',
        'mono' => 'BREW SLOWLY',
        'image' => [
            'src' => '/images/coffee-brew.webp',
            'alt' => 'Close-up proses penyeduhan kopi',
        ],
    ],

    'books' => [
        'index' => '04',
        'label' => 'PERPUSTAKAAN',
        'en' => 'BOOKS',
        'title' => ['BACA', 'SESUATU.'],
        'copy' => 'Ambil buku. Cari sudut. Tinggal lebih lama dari rencanamu.',
        'image' => [
            'src' => '/images/books-reading.webp',
            'alt' => 'Orang sedang membaca di antara rak buku',
        ],
        'marquee' => ['ARSITEKTUR', 'DESAIN', 'FOTOGRAFI', 'SENI', 'BUDAYA', 'KOPI'],
    ],

    'community' => [
        'index' => '05',
        'label' => 'KOMUNITAS',
        'en' => 'COMMUNITY',
        'title' => ['RUANG UNTUK', 'ORANG YANG', 'PUNYA IDE.'],
        'copy' => 'Lebih dari sekadar tempat minum kopi — tempat bertemunya orang, karya dan percakapan.',
        'events' => [
            ['n' => '001', 'name' => 'Ngobrol Kopi',          'desc' => 'Duduk bersama, bicara apa saja tentang kopi.', 'status' => 'Segera'],
            ['n' => '002', 'name' => 'Perbincangan Seniman',  'desc' => 'Ruang kecil untuk ide dan karya.',              'status' => 'Segera'],
            ['n' => '003', 'name' => 'Meja Komunitas',        'desc' => 'Panjang meja, beragam cerita.',                 'status' => 'Segera'],
            ['n' => '004', 'name' => 'Workshop Akhir Pekan',  'desc' => 'Belajar hal baru, pelan-pelan.',                'status' => 'Segera'],
        ],
        'image' => [
            'src' => '/images/community-people.webp',
            'alt' => 'Orang-orang mengobrol santai di dalam ruang',
        ],
    ],

    'journal' => [
        'index' => '06',
        'label' => 'JURNAL',
        'en' => 'FROM THE SPACE',
        'title' => ['DARI', 'RUANG INI.'],
        'articles' => [
            [
                'category' => 'KOPI',
                'meta' => '3 MENIT BACA',
                'title' => 'Seni menyeduh perlahan',
                'excerpt' => 'Tentang kenapa kami tak buru-buru dengan kopi.',
                'slug' => 'seni-menyeduh-perlahan',
                'date' => '2026-08-02',
                'src' => '/images/journal-cup.webp',
                'alt' => 'Secangkir kopi di atas meja kayu',
                'content' => [
                    ['type' => 'p', 'text' => 'Di Smiljan, secangkir kopi tidak diukur dengan detik, melainkan dengan kesabaran. Kami menyeduh filter satu per satu — bukan karena tidak punya mesin, tapi karena kami percaya bahwa waktu yang dihabiskan untuk menunggu adalah bagian dari rasa.'],
                    ['type' => 'p', 'text' => 'Suhu air, rasio bubuk, kecepatan tuang. Semuanya soal perhatian pada hal-hal kecil yang sering terlewat. Bagi kami, ritual inilah yang membuat kopi terasa hidup — bukan sekadar kafein yang mengawali hari, tapi jeda yang mengawali cerita.'],
                    ['type' => 'q', 'text' => 'Kopi yang baik tak perlu banyak penjelasan.'],
                    ['type' => 'p', 'text' => 'Jadi ketika kamu datang dan memesan V60, jangan heran kalau menunggu sedikit lebih lama. Seduhannya memang sengaja dibuat pelan — supaya kamu pun ikut pelan, mengikuti ritmenya.'],
                ],
            ],
            [
                'category' => 'ORANG',
                'meta' => '2 MENIT BACA',
                'title' => 'Ngobrol di meja komunal',
                'excerpt' => 'Percakapan yang dimulai dari satu meja panjang.',
                'slug' => 'ngobrol-di-meja-komunal',
                'date' => '2026-08-09',
                'src' => '/images/journal-barista.webp',
                'alt' => 'Barista menuangkan kopi untuk tamu',
                'content' => [
                    ['type' => 'p', 'text' => 'Meja panjang di tengah ruang adalah titik temu. Orang datang sendiri, duduk di ujung meja, lalu — tanpa disengaja — menjadi bagian dari percakapan yang lebih besar dari kopinya.'],
                    ['type' => 'p', 'text' => 'Beberapa cerita dimulai dari pertanyaan sederhana tentang buku yang sedang dibaca. Lainnya dari berbagi colokan, meja, atau sekadar senyum. Di sini jarak tidak dihitung dengan tempat duduk, melainkan dengan seberapa cepat seseorang merasa nyaman.'],
                    ['type' => 'p', 'text' => 'Komunitas tidak dibentuk oleh agenda. Ia tumbuh dari kebiasaan duduk bersama — di meja yang sama, menunggu kopi yang sama, membiarkan percakapan menemukan jalannya sendiri.'],
                ],
            ],
            [
                'category' => 'RUANG',
                'meta' => '4 MENIT BACA',
                'title' => 'Betapa cahaya jatuh di sore hari',
                'excerpt' => 'Catatan kecil tentang arsitektur dan ketenangan.',
                'slug' => 'betapa-cahaya-jatuh-di-sore-hari',
                'date' => '2026-08-14',
                'src' => '/images/journal-reading.webp',
                'alt' => 'Sinar matahari masuk ke dalam ruang baca',
                'content' => [
                    ['type' => 'p', 'text' => 'Sore hari di Smiljan adalah tentang cahaya. Saat matahari mulai condong, cahaya jatuh melalui jendela, memanjang melintasi lantai beton, dan menyentuh tepi rak buku yang paling jauh.'],
                    ['type' => 'p', 'text' => 'Kami sengaja merancang ruang ini agar cahaya tidak berhenti di satu titik. Arsitektur bukan hanya soal bentuk — ia tentang bagaimana cahaya, suara, dan udara bergerak di dalamnya, menemani orang yang sedang membaca atau bekerja.'],
                    ['type' => 'p', 'text' => 'Duduklah di sudut yang terkena cahaya sore. Baca beberapa halaman. Biarkan bayangan memanjang pelan-pelan. Ini bagian dari kunjungan yang tidak tercantum di menu.'],
                ],
            ],
        ],
    ],

    'quote' => [
        'en' => 'COME FOR THE COFFEE. / STAY FOR EVERYTHING ELSE.',
        'lines' => [
            ['text' => 'DATANG UNTUK',     'italic' => false],
            ['text' => 'KOPINYA.',          'italic' => true],
            ['text' => 'TINGGAL UNTUK',     'italic' => false],
            ['text' => 'SEMUA YANG LAIN.',  'italic' => true],
        ],
    ],

    'visit' => [
        'index' => '07',
        'label' => 'KUNJUNGI',
        'en' => 'VISIT',
        'title' => ['KESINI,', 'KE SELATAN.'],
        'copy' => 'Kami ada di Cilandak Barat — dekat, tapi terasa jauh dari keramaian.',
        'hours_label' => 'BUKA SETIAP HARI',
        'cta' => 'BUKA DI GOOGLE MAPS',
        'transport' => 'DISARANKAN NAIK TRANSPORTASI UMUM',
        'image' => [
            'src' => '/images/visit-exterior.webp',
            'alt' => 'Fasad arsitektural bangunan dengan cahaya bersih',
        ],
    ],

    'about' => [
        'index' => '—',
        'label' => 'TENTANG',
        'en' => 'ABOUT',
        'title' => ['CERITA', 'TENTANG', 'RUANG.'],
        'copy' => 'Smiljan Southspare adalah kedai kopi sekaligus perpustakaan kecil di Cilandak Barat — tempat untuk membaca, bekerja, bertemu, dan kadang tak melakukan apa-apa.',
        'story' => [
            'label' => 'BAGAIMANA DIMULAI',
            'copy' => 'Bermula dari kecintaan pada dua hal yang sama-sama menuntut waktu: kopi dan buku. Kami ingin membuat ruang yang merawat keduanya — tempat orang datang untuk menikmati secangkir kopi yang diseduh perlahan, lalu tinggal lebih lama dari rencananya.',
            'points' => [
                'KOPI DISEDUH PELAN — satu cangkir pada satu waktu.',
                'BUKU UNTUK DIPINJAM — koleksi pilihan, bukan pajangan.',
                'RUANG UNTUK SEMUA — dari meja komunal sampai sudut sunyi.',
            ],
        ],
        'values' => [
            ['n' => '01', 'name' => 'Pelan',   'copy' => 'Kami percaya hal baik tidak perlu diburu.'],
            ['n' => '02', 'name' => 'Teliti',  'copy' => 'Perhatian pada detail, dari seduhan sampai sapaan.'],
            ['n' => '03', 'name' => 'Terbuka', 'copy' => 'Siapa pun boleh datang, duduk, dan merasa di rumah.'],
        ],
        'image' => [
            'src' => '/images/space-architecture.webp',
            'alt' => 'Detail arsitektur beton dan cahaya di dalam ruang',
        ],
    ],

    'contact' => [
        'index' => '—',
        'label' => 'KONTAK',
        'en' => 'CONTACT',
        'title' => ['MARI', 'NGOMONG.'],
        'copy' => 'Punya pertanyaan, ide acara, atau sekadar ingin menyapa? Kirim pesan — kami senang mendengar dari kamu.',
        'items' => [
            ['label' => 'EMAIL',     'value' => 'halo@smiljan.southspare', 'href' => 'mailto:halo@smiljan.southspare'],
            ['label' => 'INSTAGRAM', 'value' => '@smiljan.southspare',     'href' => 'https://www.instagram.com/'],
            ['label' => 'ALAMAT',    'value' => 'Jl. BDN 1, Cilandak Barat', 'href' => 'https://www.google.com/maps/place/Smiljan+Southspare/@-6.279791,106.7989644,17z/data=!3m1!4b1!4m6!3m5!1s0x2e69f100033e3b7d:0xd7296777ad54c268!8m2!3d-6.279791!4d106.7963895'],
        ],
        'note' => 'KAMI MEMBALAS PELAN-PELAN — BIASANYA DALAM 1—2 HARI',
    ],

    'footer' => [
        'tagline' => 'COFFEE / BOOKS / PEOPLE / SOUTH JAKARTA',
        'links' => [
            ['label' => 'Instagram', 'href' => 'https://www.instagram.com/'],
            ['label' => 'Maps',      'href' => 'https://www.google.com/maps/place/Smiljan+Southspare/@-6.279791,106.7989644,17z/data=!3m1!4b1!4m6!3m5!1s0x2e69f100033e3b7d:0xd7296777ad54c268!8m2!3d-6.279791!4d106.7963895'],
            ['label' => 'Kontak',    'href' => 'mailto:halo@smiljan.southspare'],
        ],
    ],

    'status' => [
        'open_now' => 'SEDANG BUKA',
        'closed' => 'TUTUP',
        'opens_at' => 'BUKA',
    ],
];
