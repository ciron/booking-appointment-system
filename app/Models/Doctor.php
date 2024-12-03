<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use  HasFactory, Notifiable;



    protected $guarded = [];

    protected $hidden = [
        'password',

    ];
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function slots()
    {
        return $this->hasMany(DoctorSlot::class);
    }


    protected $casts = [

        'password' => 'hashed',
    ];
}
