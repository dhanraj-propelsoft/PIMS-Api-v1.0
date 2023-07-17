<?php 
namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ErrorApiResponse implements Responsable
{
    protected $data,$code;
 

    public function __construct($data,$code = null)
    {
        $this->data = $data;   
        $this->code = ($code)?$code:500;      
    }

    public function toResponse($request)
    {
       
        return response()->json([
            'data' => $this->data,
            'status_code' => $this->code,
        ], 500);
    }
}
