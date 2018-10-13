<?php
namespace App\Enjoythetrip\Repositories; /* Lecture 27 */

use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;  /* Lecture 27 */
use App\{TouristObject/* Lecture 28 */};

/* Lecture 27 */
class BackendRepository implements BackendRepositoryInterface  {   
    
    
    /* Lecture 28 */
    public function getOwnerReservations($request)
    {
        return TouristObject::with([

                  'rooms' => function($q) {
                        $q->has('reservations'); // works like where clause for Room
                    }, // give me rooms only with reservations, if it wasn't there would be rooms without reservations

                    'rooms.reservations.user'

                  ])
                    ->has('rooms.reservations') // ensures that it gives me only those objects that have at least one reservation, has() here works like where clause for Object
                    ->where('user_id', $request->user()->id)
                    ->get();
    }
    
    
    /* Lecture 28 */
    public function getTouristReservations($request)
    {

       return TouristObject::with([

                    'rooms.reservations' => function($q) use($request) { // filters reserervations of other users

                            $q->where('user_id',$request->user()->id);

                    },

                    'rooms'=>function($q) use($request){
                        $q->whereHas('reservations',function($query) use($request){
                            $query->where('user_id',$request->user()->id);
                        });
                    },
                    
                    'rooms.reservations.user'

                  ])

                    ->whereHas('rooms.reservations',function($q) use($request){  // acts like has() with additional conditions

                        $q->where('user_id',$request->user()->id);

                    })
                    ->get();
    }
 
  
}








 