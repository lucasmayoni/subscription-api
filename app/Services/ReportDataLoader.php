<?php


namespace App\Services;


use App\Subscription;
use App\SubscriptionData;
use Illuminate\Support\Facades\Log;

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
    /**
     * @var SubscriptionData
     */
    private $subscriptionData;

    public function __construct(\Psr\Log\LoggerInterface $log, Subscription $subscription, SubscriptionData $subscriptionData)
    {
        $this->log = $log;
        $this->subscription = $subscription;
        $this->subscriptionData = $subscriptionData;
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

    /**
     * @inheritDoc
     */
    public function generateReport($date, $totalActiveSubscriptions, $totalNewSubscriptions, $totalCancelledSubscriptions)
    {
        if(!$this->subscriptionData->query()->where('report_date', $date[0])->first()){
            Log::info(__METHOD__,compact('date','totalCancelledSubscriptions', 'totalNewSubscriptions', 'totalActiveSubscriptions'));

            $this->subscriptionData->setAttribute('report_date', $date[0]);
            $this->subscriptionData->setAttribute('total_cancelled_subscriptions', $totalCancelledSubscriptions);
            $this->subscriptionData->setAttribute('total_new_subscriptions', $totalNewSubscriptions);
            $this->subscriptionData->setAttribute('total_active_subscriptions', $totalActiveSubscriptions);
            $this->subscriptionData->save();

            return $this->subscriptionData->getAttribute('id');
        }
    }
}
