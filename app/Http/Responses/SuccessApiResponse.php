<?php 
namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class SuccessApiResponse implements Responsable
{
   
 

    public function __construct($data)
    {

        $this->data = $data;       
    }

    public function toResponse($request)
    {
      
        return response()->json([
            'data' => $this->data,
            'status_code' =>200,
        ], 200);
    }
}
