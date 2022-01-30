<?php

namespace App;

use App\Events\UserRegisteredEvent;
use App\Helpers\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OtpCode extends Model
{
    use UsesUuid;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            event(new UserRegisteredEvent($model->user));
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
