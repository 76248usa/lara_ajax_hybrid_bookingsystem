<?php 


namespace App\Enjoythetrip\Gateways; /* Lecture 17 */

use App\Enjoythetrip\Interfaces\FrontendRepositoryInterface; /* Lecture 17 */ 


/* Lecture 17 */
class FrontendGateway { 
    
    use \Illuminate\Foundation\Validation\ValidatesRequests; /* Lecture 25 */
    
     
    /* Lecture 17 */
    public function __construct(FrontendRepositoryInterface $fR ) 
    {
        $this->fR = $fR;
    }
    
    
    /* Lecture 17 */
    public function searchCities($request)
    {
        $term = $request->input('term');

        $results = array();

        $queries = $this->fR->getSearchCities($term);

        foreach ($queries as $query)
        {
            $results[] = ['id' => $query->id, 'value' => $query->name];
        }

        return $results;
    } 
    
    
    /* Lecture 18 */
    public function getSearchResults($request)
    {

        if( $request->input('city') != null)
        {
            
            $dayin = date('Y-m-d', strtotime($request->input('check_in'))); /* Lecture 19 */
            $dayout = date('Y-m-d', strtotime($request->input('check_out'))); /* Lecture 19 */

            $result = $this->fR->getSearchResults($request->input('city'));

            if($result)
            {

                /* Lecture 19 */
                foreach ($result->rooms as $k=>$room)
                {
                   if( (int) $request->input('room_size') > 0 )
                   {
                        if($room->room_size != $request->input('room_size'))
                        {
                            $result->rooms->forget($k);
                        }
                   }

                    foreach($room->reservations as $reservation)
                    {

                        if( $dayin >= $reservation->day_in
                            &&  $dayin <= $reservation->day_out
                        )
                        {
                            $result->rooms->forget($k);
                        }
                        elseif( $dayout >= $reservation->day_in
                            &&  $dayout <= $reservation->day_out
                        )
                        {
                            $result->rooms->forget($k);
                        }
                        elseif( $dayin <= $reservation->day_in
                            &&  $dayout >= $reservation->day_out
                        )
                        {
                            $result->rooms->forget($k);
                        }

                    }

                }

                $request->flash(); // inputs for session for one request

                /* Lecture 19 */
                if(count($result->rooms)> 0)
                return $result;  // filtered result
                else return false;

            }

        }
        
        return false;

    }
    
    
    /* Lecture 25 */
    public function addComment($commentable_id, $type, $request)
    {
        $this->validate($request,[
            'content'=>"required|string"
        ]);
        
        return $this->fR->addComment($commentable_id, $type, $request);
    }
    
    
    /* Lecture 26 */
    public function checkAvaiableReservations($room_id, $request)
    {

        $dayin = date('Y-m-d', strtotime($request->input('checkin')));
        $dayout = date('Y-m-d', strtotime($request->input('checkout')));

        $reservations = $this->fR->getReservationsByRoomId($room_id);

        $avaiable = true;
        foreach($reservations as $reservation)
        {
            if( $dayin >= $reservation->day_in
                &&  $dayin <= $reservation->day_out
            )
            {
                $avaiable = false;break;
            }
            elseif( $dayout >= $reservation->day_in
                &&  $dayout <= $reservation->day_out
            )
            {
                $avaiable = false;break;
            }
            elseif( $dayin <= $reservation->day_in
                &&  $dayout >= $reservation->day_out
            )
            {
                $avaiable = false;break;
            }
        }

        return $avaiable;
    }
    
    
    /* Lecture 26 */
    public function makeReservation($room_id, $city_id, $request)
    {
        $this->validate($request,[
            'checkin'=>"required|string",
            'checkout'=>"required|string"
        ]);
        
        return $this->fR->makeReservation($room_id, $city_id, $request);
    }
    

}














