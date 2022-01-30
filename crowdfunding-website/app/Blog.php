<?php

namespace App;

use App\Helpers\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use UsesUuid;

    protected $guarded = [];
}
