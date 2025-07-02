<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model

{
   protected $table = 'feedbacks';
   protected $fillable = ['user_id', 'event_id','booking_id', 'feedback', 'rating'];

   public function event()
   {
      return $this->belongsTo(Event::class);
   }

   public function user()
   {
      return $this->belongsTo(User::class);
   }

   public function booking()
   {
      return $this->belongsTo(Booking::class);
   }
}
