<?php 
namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ErrorApiResponse implements Responsable
{
    protected $data;
 

    public function __construct($data)
    {
        $this->data = $data;       
    }

    public function toResponse($request)
    {
        return response()->json([
            'data' => $this->data,
            'status_code' =>500,
        ], 500);
    }
}