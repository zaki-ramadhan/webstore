<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    /**
     * !!! This Seeder is can not to use because always hit timed out error while fetching data so long, Use sql file instead.
     */
    public function run(): void
    {
        // prevent timed out erro while fetching takes so long
        set_time_limit(0);

        // fetch data via API to wilayah id (nested loop)
        $this->command->info('Fetching Provinces...');
        $provinces = Http::get('https://wilayah.id/api/provinces.json')->json('data');
        foreach ($provinces as $province) {
            Region::create([
                'code' => data_get($province, 'code'),
                'name' => data_get($province, 'name'),
                'type' => 'province',
                'parent_code' => null,
            ]);

            // inside province
            $this->command->info("Fetching Regencies for {$province['name']}...");
            $regencies = Http::get("https://wilayah.id/api/regencies/{$province['code']}.json")->json('data');
            foreach ($regencies as $regency) {
                Region::create([
                    'code' => data_get($regency, 'code'),
                    'name' => data_get($regency, 'name'),
                    'type' => 'regency',
                    'parent_code' => data_get($province, 'code'),
                ]);

                // inside regency
                $this->command->info("Fetching Districts for {$regency['name']}...");
                $districts = Http::get("https://wilayah.id/api/districts/{$regency['code']}.json")->json('data');
                foreach ($districts as $district) {
                    Region::create([
                        'code' => data_get($district, 'code'),
                        'name' => data_get($district, 'name'),
                        'type' => 'district',
                        'parent_code' => data_get($regency, 'code'),
                    ]);

                    // inside district
                    $this->command->info("Fetching Villages for {$district['name']}...");
                    $villages = Http::get("https://wilayah.id/api/villages/{$district['code']}.json")->json('data');
                    foreach ($villages as $village) {
                        Region::create([
                            'code' => data_get($village, 'code'),
                            'name' => data_get($village, 'name'),
                            'type' => 'village',
                            'postal_code' => data_get($village, 'postal_code'),
                            'parent_code' => data_get($district, 'code'),
                        ]);
                    }
                }
            }
        }
    }
}
