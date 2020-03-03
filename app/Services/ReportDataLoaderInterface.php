<?php


namespace App\Services;


interface ReportDataLoaderInterface
{
    /**
     * @param $date
     * @return mixed
     */
    public function totalActiveSubscriptions($date);

    /**
     * @param $date
     * @return mixed
     */
    public function totalNewSubscriptions($date);

    /**
     * @param $date
     * @return mixed
     */
    public function totalCancelledSubscriptions($date);
}
