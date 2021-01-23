<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class demande extends Model
{
    use HasFactory;
    protected $fillable = ['id','adress','stat','id_user'];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
