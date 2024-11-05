<?php

namespace Database\Seeders\Lookups;

use Carbon\Carbon;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->disableForeignKeys();
        $this->truncateMultiple(['cities']);

        $cities = array(
            array('id' => 1,'name' => "Al-Riyadh", 'name_ar' => 'الرياض', 'country_id' => 1 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 2,'name' => "Amman", 'name_ar' => 'عمّان', 'country_id' => 2 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 3,'name' => "Abu-Dhabi", 'name_ar' => 'أبو ظبي', 'country_id' => 3 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 4,'name' => "Kuwait", 'name_ar' => 'كويت', 'country_id' => 4 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 5,'name' => "Beirut", 'name_ar' => 'بيروت', 'country_id' => 5 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 6,'name' => "Baghdad", 'name_ar' => 'بغداد', 'country_id' => 6 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 7,'name' => "Al-Doha", 'name_ar' => 'الدوحة', 'country_id' => 7 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),

        );
        DB::table('cities')->insert($cities);

        $this->disableForeignKeys();
    }
}
