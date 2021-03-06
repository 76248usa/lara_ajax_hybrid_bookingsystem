<?php
namespace App; /* Lecture 16 */

use Illuminate\Database\Eloquent\Model; /* Lecture 16 */

/* Lecture 16 */
class Room extends Model
{
    /* Lecture 16 */
    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable');
    }
    
    /* Lecture 17 */
    public function object()
    {
        return $this->belongsTo('App\TouristObject','object_id');
    }

    public function reservations()
        {
            return $this->hasMany('App\Reservation');
        }
    
}

