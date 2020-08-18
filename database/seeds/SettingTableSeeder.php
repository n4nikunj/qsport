<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\GeneralConfiguration;
class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $settingArray = [
        	['name'=>'from_email', 'value' => 'admin@admin.com', 'status' => 'active' ],
        	['name'=>'contact_no', 'value' => '+91 1234567890', 'status' => 'active' ],
        	['name'=>'facebook_url', 'value' => 'www.facebook.coms', 'status' => 'active' ],
            ['name'=>'twitter_url', 'value' => 'www.twitter.com', 'status' => 'active' ],
            ['name'=>'AUTHY_API_KEY', 'value' => 'xLK6cqFkMZgJkAONrPC1avgtugRb4Wmn', 'status' => 'active' ],
            ['name'=>'TWILIO_AUTH_TOKEN', 'value' => 'c03645a01213bd789c4444b7116f33a5', 'status' => 'active' ],
            ['name'=>'TWILIO_AUTH_SID', 'value' => 'AC4393f3f22d00a04030caca36b78f27b3', 'status' => 'active' ],
            ['name'=>'TWILIO_WHATSAPP_FROM', 'value' => 'google_api_key', 'status' => 'active' ],
            ['name'=>'TWILIO_FROM', 'value' => '+19373193361', 'status' => 'active' ],
            ['name'=>'site_name', 'value' => 'QSport', 'status' => 'active' ],
        	['name'=>'google_API_key', 'value' => 'google_api_key', 'status' => 'active' ],
        ];
		foreach ($settingArray as $key => $value) {
			Setting::create($value);
        }


        // General Configurations
        $generalConfigArray = [
            ['name'=>'free_training_sheet', 'value' => '15'],
            ['name'=>'product_posting_price', 'value' => '10'],  
        ];
        foreach ($generalConfigArray as $key => $value) {
            GeneralConfiguration::create($value);
        }
    }
}
