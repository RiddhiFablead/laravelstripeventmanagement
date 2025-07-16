<?php

namespace App\Models;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table='booking';
    protected $fillable=['event_id','event_schedule_id','name','email'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function schedule()
    {
        return $this->belongsTo(EventSchedule::class,'event_schedule_id');
    }
 



}
