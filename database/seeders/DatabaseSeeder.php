<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DeviceCategory;
use App\Models\JenisDevice;
use App\Models\PenanggungJawab;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(100)->create();

        DeviceCategory::create([
            'jenis_id' => 1,
            'name' => 'Router',
        ]);
        DeviceCategory::create([
            'jenis_id' => 2,
            'name' => 'Fiber Optik',
        ]);

        JenisDevice::create([
            'name' => 'device',
        ]);
        JenisDevice::create([
            'name' => 'kabel',
        ]);

        \App\Models\User::create([
            'username' => 'admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'admin'
        ]);
        Category::create([
            'name' => 'Sengked',

        ]);
        Category::create([
            'name' => 'ASNet',

        ]);

        Category::create([
            'name' => 'SF',

        ]);
        PenanggungJawab::create([
            'name' => 'Chandra Dermawan',
            'category_id' => '1',

        ]);
        PenanggungJawab::create([
            'name' => 'Dede Cahyadi',
            'category_id' => '1',

        ]);
        PenanggungJawab::create([
            'name' => 'Handy Maulana',
            'category_id' => '1',

        ]);
        PenanggungJawab::create([
            'name' => 'Nurul Arizka',
            'category_id' => '1',

        ]);
        PenanggungJawab::create([
            'name' => 'Raja Kurnia Putra',
            'category_id' => '1',

        ]);
        PenanggungJawab::create([
            'name' => 'Reyhan Putra Renandar',
            'category_id' => '1',

        ]);
    }
}
