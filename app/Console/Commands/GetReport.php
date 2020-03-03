<?php

namespace App\Console\Commands;

use App\Subscription;
use Illuminate\Console\Command;

class GetReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:report {--d|date=* : Date to get report}}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Subscriptions Report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(\Psr\Log\LoggerInterface $logger)
    {
        //
        try {
            $date = $this->input->getOption('date');
            $logger->info(__METHOD__ . ' Call with...', compact('date'));
            $this->output->title("Get Subscription Data - Started...");
            $this->info("Get Subscription info...");

            $loader = app()->make(\App\Services\ReportDataLoader::class);
            $totalActiveSubscriptions = $loader->totalActiveSubscriptions($date);
            $totalNewSubscriptions = $loader->totalNewSubscriptions($date);
            $totalCancelledSubscriptions = $loader->totalCancelledSubscriptions($date);
            $this->info("TotalSubscriptions: ". $totalActiveSubscriptions);
            $this->info("TotalNewSubscriptions: ". $totalNewSubscriptions);
            $this->info("TotalCancelledSubscriptions: ". $totalCancelledSubscriptions);

        } catch (\Exception $ex) {

        }
    }
}
