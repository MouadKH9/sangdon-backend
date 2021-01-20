<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class demande extends Model
{
    use HasFactory;
    protected $fillable = ['id_dem','adress','stat','id_user'];
    protected $primaryKey = 'id_dem';
    public $timestamps = false;
}
