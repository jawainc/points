<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting();
        $setting->name = 'Enable Student Password';
        $setting->value = '0';
        $setting->type = 'checkbox';
        $setting->save();
    }
}
