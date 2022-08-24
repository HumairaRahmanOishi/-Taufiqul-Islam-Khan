<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $dataCount=10;

        $this->command->info("Creating {$dataCount} Admin.");
        
        $datas = factory(App\Models\Admin::class, $dataCount)->create();

        $this->command->info("{$dataCount} Admin Created.");
    }

     // Return random value in given range
    function count($range)
    {
        return rand(...explode('-', $range));
    }
}
