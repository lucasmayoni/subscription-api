<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Subscription extends Model
{
    use SoftDeletes;

    protected $table = 'subscription';
    public $primaryKey = 'id';
    protected $fillable = [
        'subscriber_id',
        'service_id',
        'insert_date'
    ];

    public function subscribers()
    {
        return $this->belongsTo(Subscriber::class, 'subscriber_id', 'id');
    }

    public function services()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
    public function findWithParams($msisdn, $service)
    {
        return $this->query()->select('subscription.id')
        ->join('subscriber','subscriber.id','=', 'subscription.subscriber_id')
        ->join('service', 'service.id','=','subscription.service_id')
        ->where('service.description','=', $service)
        ->where('subscriber.msisdn','=',$msisdn)->firstOrFail();
    }

    /**
     * @param $date
     * @return int
     */
    public function totalActiveSubscriptions($date)
    {
        return $this->query()->where('insert_date','<=', $date[0])->count();
    }

    /**
     * @param $date
     * @return int
     */
    public function totalNewSubscriptions($date)
    {
        return $this->query()->where('insert_date','=', $date[0])->count();
    }

    /**
     * @param $date
     * @return int
     */
    public function totalCancelledSubscriptions($date)
    {
        $dateFrom = Carbon::createFromFormat('Y-m-d', $date[0])->startOfDay();
        $dateTo = Carbon::createFromFormat('Y-m-d', $date[0])->endOfDay();
        Log::info(__METHOD__, compact('dateFrom', 'dateTo'));
        $all = $this->withTrashed()->get();
        return $all->where('deleted_at', '>=', $dateFrom)
                    ->where('deleted_at','<=', $dateTo)->count();


    }
}
