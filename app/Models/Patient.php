<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Patient extends Model
{
    use HasApiTokens, HasFactory, Notifiable,Authenticatable;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    protected $casts = [

        'password' => 'hashed',
    ];
}
