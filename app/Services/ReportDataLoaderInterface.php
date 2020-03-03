<?php


namespace App\Services;


interface ReportDataLoaderInterface
{
    /**
     * @param $date
     * @return int
     */
    public function totalActiveSubscriptions($date);

    /**
     * @param $date
     * @return int
     */
    public function totalNewSubscriptions($date);

    /**
     * @param $date
     * @return int
     */
    public function totalCancelledSubscriptions($date);

    /**
     * @param $date
     * @param $totalActiveSubscriptions
     * @param $totalNewSubscriptions
     * @param $totalCancelledSubscriptions
     * @return mixed
     */
    public function generateReport($date, $totalActiveSubscriptions, $totalNewSubscriptions, $totalCancelledSubscriptions);
}
