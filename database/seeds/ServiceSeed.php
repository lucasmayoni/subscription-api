<?php

use App\Subscriber;
use Illuminate\Database\Seeder;

class ServiceSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('service.services') as $row) {
            \App\Service::firstOrCreate(['description' => $row['description']], $row);
        }
    }
}
