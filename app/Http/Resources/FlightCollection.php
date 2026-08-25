<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Traits\RestApi;

class FlightCollection extends ResourceCollection
{
    use RestApi;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data['data'] = $this->collection;
        $data['message'] = !empty($this->msg)?$this->msg:"";
        $data['statusCode'] = !empty($this->code)?$this->code:"200";
        $data['accessToken'] = $this->accessToken??"";
        return $this->jsonResponse($data);
        return parent::toArray($request);
    }
}

   