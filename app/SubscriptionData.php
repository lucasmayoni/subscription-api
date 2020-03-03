<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionData extends Model
{
    //
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'subscription_data';
    protected $fillable = [
        'report_date',
        'total_active_subscriptions',
        'total_new_subscriptions',
        'total_cancelled_subscriptions'
    ];
}
