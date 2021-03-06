<?php

namespace App;

use App\Helpers\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use UsesUuid;

    protected $guarded = [];
}
