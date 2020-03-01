<?php

use Illuminate\Database\Seeder;

class SubscriberSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('subscribers.subs') as $row) {
            \App\Subscriber::firstOrCreate(['msisdn' => $row['msisdn']], $row);
        }
    }
}
