<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Booking extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'category_id', 'user_id', 'name','phone','address','check_in_at','check_out_at','paid','booking_number','email','description'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
