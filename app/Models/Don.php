<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Don extends Model
{
    use HasFactory, Notifiable;


    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'adresse',
    ];

    //l'utilisateur qui a effectué le don
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    //type de sang du don
    public function typesang()
    {
        return $this->belongsTo(TypeSang::class,'typesang_id');
    }
}
