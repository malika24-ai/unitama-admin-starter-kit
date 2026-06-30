<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
        'app_name'=> 'Admin laravel',
        'copyright'=> 'Admin laravel ||2026',
        'login_title'=> 'Admin laravel',
        'desription'=> 'Panel kendali pusat (Root Admin) berbasis
        Laravel untuk mengelola seluruh ekosistem aplikasi, hak akses pengguna, konfigurasi sistem,
        dan manajemen data secara aman dan terintegrasi.',
        
        'keywords'=> 'root admin, dashboard admin, sistem manajemen internal, 
        laravel admin panel, aplikasi backoffice, manajemen pengguna, pengontrol sistem',
        ]);
    }
}
