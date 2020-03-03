<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
