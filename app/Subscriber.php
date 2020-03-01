<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    //
    protected $table = 'subscriber';

    protected $primaryKey = 'id';

    protected $fillable = [
        'msisdn',
        'email',
        'name',
        'blocked'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function findByMsisdn($msisdn)
    {
        $subs = $this->query()->where('msisdn', $msisdn)->pluck('id');
        return $subs->first();
    }
}
