<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Chat extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at'  => 'date:h:m a',
    ];

 /*   public function setDateAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('h:m a');
    }*/
    public function sender(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class,'receiver_id');
    }
}
