<?php

namespace App;

use App\Events\UserRegisteredEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OtpCode extends Model
{
    protected $guarded = [];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });

        static::created(function ($model) {
            event(new UserRegisteredEvent($model->user));
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
