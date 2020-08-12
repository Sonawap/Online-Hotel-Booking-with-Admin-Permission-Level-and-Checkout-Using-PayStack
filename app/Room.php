<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number', 'description', 'avaliable','category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
