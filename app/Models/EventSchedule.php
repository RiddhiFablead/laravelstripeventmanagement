<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    use HasFactory;
    protected $table='events_schedules';
    protected $fillable=['event_id','date','time'];
    public function event()
    {
         return $this->belongsTo(Event::class,'event_id');
    }
}
