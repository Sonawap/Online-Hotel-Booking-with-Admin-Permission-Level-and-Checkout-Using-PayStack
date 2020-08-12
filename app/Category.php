<?php

namespace App;

use App\Room;
use App\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'description', 'image','price'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }


}
