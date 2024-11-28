<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Patient extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
}