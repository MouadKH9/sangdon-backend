<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class demande extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id_dem', 'adress', 'stat', 'id_user'];
    protected $primaryKey = 'id_dem';
    public $timestamps = false;
}
