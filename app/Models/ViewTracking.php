<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewTracking extends Model
{
    use HasFactory;

    protected $table = 'view_tracking';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
