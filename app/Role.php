<?php
namespace App; /* Lecture 27 */

use Illuminate\Database\Eloquent\Model; /* Lecture 27 */

/* Lecture 27 */
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}


