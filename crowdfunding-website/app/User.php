<?php

namespace App;

use App\Helpers\UsesUuid;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'role_id', 'photo'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->generateOtpCode();
        });
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function otp_code()
    {
        return $this->hasOne('App\OtpCode');
    }

    public function isVerification()
    {
        return $this->email_verified_at == null ? false : true;
    }

    public function isAdmin()
    {
        return $this->role->name == 'admin' ? true : false;
    }

    public function generateOtpCode()
    {
        $this->otp_code()->updateOrCreate(
            ['user_id' => $this->id],
            [
                'otp' => random_int(100000, 999999),
                'valid_until' => Carbon::now()->addMinutes(5)
            ]
        );
    }
}
