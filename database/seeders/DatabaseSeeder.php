<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProgramName;
use App\Models\Subject;
use App\Models\Specalization;
use App\Models\Commission;
use App\Models\Application;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Userlar
        $usedPhones = ['998901234567', '998999999999'];
        User::factory()->create([
            'phone' => '998901234567',
            'last_name' => 'test',
            'first_name' => 'testov',
            'middle_name' => 'testovich',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        User::factory()->create([
            'phone' => '998999999999',
            'last_name' => 'Admin',
            'first_name' => 'Test',
            'middle_name' => 'User',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        
        // Program names
        $programNames = [
            ['name' => 'Muhandislik geometriyasi va kompyuter grafikasi. Audio va video-texnologiyalari', 'code' => '05.01.01'],
            ['name' => 'Tizimli tahlil, boshqaruv va axborotni qayta ishlash', 'code' => '05.01.02'],
            ['name' => 'Informatikaning nazariy asoslari', 'code' => '05.01.03'],
            ['name' => 'Hisoblash mashinalari, majmualari va kompyuter tarmoqlarining matematik va dasturiy ta’minoti', 'code' => '05.01.04'],
            ['name' => 'Axborotlarni himoyalash usullari va tizimlari. Axborot xavfsizligi', 'code' => '05.01.05'],
            ['name' => 'Matematik modellashtirish. Sonli usullar va dasturlar majmui', 'code' => '05.01.07'],
            ['name' => 'Hujjatshunoslik. Arxivshunoslik. Kutubxonashunoslik', 'code' => '05.01.09'],
            ['name' => 'Axborot olish tizimlari va jarayonlari', 'code' => '05.01.10'],
            ['name' => 'Raqamli texnologiyalar va sun’iy intellect', 'code' => '05.01.11'],
            ['name' => 'Telekommunikatsiya va kompyuter tizimlari, telekommunikatsiya tarmoqlari va qurilmalari. Axborotlarni taqsimlash', 'code' => '05.04.01'],
            ['name' => 'Radiotexnika, radionavigatsiya, radiolokatsiya va televideniye tizimlari va qurilmalari. Mobil va optik tolali aloqa tizimlari', 'code' => '05.04.02'],
            ['name' => 'Xizmat ko‘rsatish tarmoqlari iqtisodiyoti', 'code' => '08.00.05'],
            ['name' => 'Raqamli iqtisodiyot va xalqaro raqamli integratsiya', 'code' => '08.00.16'],
        ];
        foreach ($programNames as $item) {
            ProgramName::updateOrCreate(['code' => $item['code']], ['name' => $item['name'], 'code' => $item['code']]);
        }
    }
}
