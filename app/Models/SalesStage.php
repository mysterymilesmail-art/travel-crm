<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesStage extends Model
{
    protected $fillable = ['name','order','active'];
}