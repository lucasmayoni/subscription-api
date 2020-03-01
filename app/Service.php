<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $table = 'service';

    protected $primaryKey = 'id';

    protected $fillable = [
        'description',
        'is_disabled'
    ];


    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function findByServiceName($name)
    {
        $subs = $this->query()->where('description', $name)->pluck('id');
        return $subs->first();
    }
}
