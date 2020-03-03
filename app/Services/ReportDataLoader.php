<?php


namespace App\Services;


use App\Subscription;

class ReportDataLoader implements ReportDataLoaderInterface
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $log;
    /**
     * @var Subscription
     */
    private $subscription;

    public function __construct(\Psr\Log\LoggerInterface $log, Subscription $subscription)
    {
        $this->log = $log;
        $this->subscription = $subscription;
    }

    /**
     * @inheritDoc
     */
    public function totalActiveSubscriptions($date)
    {
        return $this->subscription->totalActiveSubscriptions($date);
    }

    /**
     * @inheritDoc
     */
    public function totalNewSubscriptions($date)
    {
        return $this->subscription->totalNewSubscriptions($date);
    }

    /**
     * @inheritDoc
     */
    public function totalCancelledSubscriptions($date)
    {
        return $this->subscription->totalCancelledSubscriptions($date);
    }
}
