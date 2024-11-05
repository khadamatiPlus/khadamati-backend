<?php

namespace Database\Seeders\Lookups;

use Carbon\Carbon;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
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
        $this->truncateMultiple(['countries']);

        $countries = array(
            array('id' => 1,'name' => "Saudi Arabia", 'name_ar' => 'السعودية', 'code' => 'SA' ,'phone_code' => 966, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 2,'name' => "Jordan", 'name_ar' => 'الأردن', 'code' => 'JO' ,'phone_code' => 962, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 3,'name' => "United Arab Emirates", 'name_ar' => 'الامارات العربية المتحدة', 'code' => 'AE' ,'phone_code' => 971, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 4,'name' => "Kuwait", 'name_ar' => 'الكويت', 'code' => 'KW' ,'phone_code' => 965, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 5,'name' => "Lebanon", 'name_ar' => 'لبنان', 'code' => 'LB' ,'phone_code' => 961, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 6,'name' => "Iraq", 'name_ar' => 'العراق', 'code' => 'IQ' ,'phone_code' => 964, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),
            array('id' => 7,'name' => "Qatar", 'name_ar' => 'قطر', 'code' => 'QA' ,'phone_code' => 974, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by_id' => 1, 'updated_by_id' => 1),

        );
        DB::table('countries')->insert($countries);

        $this->disableForeignKeys();
    }
}
