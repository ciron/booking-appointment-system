<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSlot extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function appointment()
    {
        return $this->hasOne(Appointment::class,'doctor_slots_id');
    }
}
