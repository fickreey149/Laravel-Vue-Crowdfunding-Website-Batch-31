<?php

namespace App;

use App\Helpers\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    use UsesUuid;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
