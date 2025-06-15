<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // --- Produk-produk yang mungkin sudah ada (contoh saja, tambahkan atau sesuaikan jika perlu) ---
            [
                'nama'      => 'Tenda Dome 4 Orang',
                'harga'     => 180000,
                'deskripsi' => 'Tenda dome kapasitas 4 orang, cocok untuk camping keluarga atau kelompok kecil.',
                'gambar'    => 'tenda_dome.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'      => 'Kompor Gas Portable',
                'harga'     => 65000,
                'deskripsi' => 'Kompor kecil ringan untuk memasak saat di alam terbuka. Menggunakan gas kaleng.',
                'gambar'    => 'kompor_portable.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'      => 'Sleeping Bag Tebal',
                'harga'     => 85000,
                'deskripsi' => 'Sleeping bag hangat dengan bahan tahan air, nyaman untuk suhu dingin.',
                'gambar'    => 'sleeping_bag.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'      => 'Matras Camping',
                'harga'     => 35000,
                'deskripsi' => 'Matras gulung empuk untuk tidur di alam bebas. Ringan dan mudah dibawa.',
                'gambar'    => 'matras_camping.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'      => 'Headlamp LED',
                'harga'     => 40000,
                'deskripsi' => 'Lampu kepala LED tahan lama dengan 3 mode cahaya. Ideal untuk mendaki malam.',
                'gambar'    => 'headlamp_led.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'      => 'Nestle Gas Kaleng',
                'harga'     => 18000,
                'deskripsi' => 'Gas kaleng isian butane untuk kompor portable. Berat bersih 230gr.',
                'gambar'    => 'gas_kaleng.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'      => 'Ransel Hiking 40L',
                'harga'     => 120000,
                'deskripsi' => 'Tas ransel besar dengan banyak kompartemen. Cocok untuk perjalanan hiking dan trekking.',
                'gambar'    => 'ransel_hiking.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'      => 'Tongkat Hiking Teleskopik',
                'harga'     => 60000,
                'deskripsi' => 'Tongkat trekking lipat untuk naik gunung. Bahan aluminium ringan.',
                'gambar'    => 'trekking_pole.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'      => 'Jaket Outdoor Waterproof',
                'harga'     => 140000,
                'deskripsi' => 'Jaket tahan angin dan hujan untuk hiking. Dilengkapi hoodie dan banyak saku.',
                'gambar'    => 'jaket_waterproof.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'      => 'Cooking Set Portable',
                'harga'     => 95000,
                'deskripsi' => 'Set alat masak ringan dan ringkas untuk camping. Termasuk panci dan wajan.',
                'gambar'    => 'cooking_set.png',
                'created_at' => date('Y-m-d H:i:s'),
            ],

            // --- 11 Produk BARU yang akan ditambahkan ---
            [
                'nama'      => 'Botol Minum Lipat 1L',
                'harga'     => 45000,
                'deskripsi' => 'Botol minum silikon yang bisa dilipat, hemat tempat, cocok untuk kegiatan outdoor.',
                'gambar'    => 'botol_minum_lipat.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'nama'      => 'Senter Kepala LED 5 Mode',
                'harga'     => 55000,
                'deskripsi' => 'Senter kepala dengan fokus adjustable dan 5 mode pencahayaan, baterai tahan lama.',
                'gambar'    => 'senter_kepala_led.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'nama'      => 'Sarung Tangan Hiking Anti Slip',
                'harga'     => 30000,
                'deskripsi' => 'Sarung tangan dengan grip anti slip, melindungi tangan saat hiking dan climbing.',
                'gambar'    => 'sarung_tangan_hiking.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
            [
                'nama'      => 'Kompas Navigasi Profesional',
                'harga'     => 75000,
                'deskripsi' => 'Kompas presisi tinggi untuk navigasi di hutan atau pegunungan. Dilengkapi cermin.',
                'gambar'    => 'kompas_navigasi.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
            ],
            [
                'nama'      => 'Tas P3K Outdoor Kecil',
                'harga'     => 50000,
                'deskripsi' => 'Tas P3K kompak berisi perlengkapan dasar untuk pertolongan pertama saat berpetualang.',
                'gambar'    => 'tas_p3k_outdoor.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
            [
                'nama'      => 'Hammock Nylon Portable',
                'harga'     => 80000,
                'deskripsi' => 'Ayunan hammock terbuat dari nylon ringan, kuat, dan mudah dipasang. Termasuk tali.',
                'gambar'    => 'hammock_nylon.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 days')),
            ],
            [
                'nama'      => 'Cangkir Lipat Outdoor Stainless',
                'harga'     => 25000,
                'deskripsi' => 'Cangkir lipat stainless steel, anti karat, ringan, dan mudah disimpan.',
                'gambar'    => 'cangkir_lipat.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
            ],
            [
                'nama'      => 'Jas Hujan Ponco Outdoor',
                'harga'     => 60000,
                'deskripsi' => 'Jas hujan model ponco multifungsi, bisa sebagai tenda darurat. Bahan waterproof.',
                'gambar'    => 'jas_hujan_ponco.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-8 days')),
            ],
            [
                'nama'      => 'Sepatu Gunung Waterproof Pria',
                'harga'     => 250000,
                'deskripsi' => 'Sepatu gunung tahan air dengan sol anti slip, nyaman untuk medan berat.',
                'gambar'    => 'sepatu_gunung_pria.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-9 days')),
            ],
            [
                'nama'      => 'Filter Air Portabel Survival',
                'harga'     => 150000,
                'deskripsi' => 'Alat filter air minum portabel untuk kebutuhan survival di alam bebas.',
                'gambar'    => 'filter_air_portabel.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
            ],
            [
                'nama'      => 'Sarung Tangan Winter Tebal',
                'harga'     => 70000,
                'deskripsi' => 'Sarung tangan tebal untuk cuaca dingin ekstrem. Material insulasi termal.',
                'gambar'    => 'sarung_tangan_winter.png',
                'created_at' => date('Y-m-d H:i:s', strtotime('-11 days')),
            ],
        ];

        // Hapus data lama jika ingin mengulang dari awal setiap kali seeder dijalankan
        // $this->db->table('products')->truncate(); // TIDAK DISARANKAN jika hanya ingin MENAMBAH
        
        // Masukkan data baru
        $this->db->table('products')->insertBatch($data);
    }
}