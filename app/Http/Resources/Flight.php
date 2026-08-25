<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\RestApi;

class Flight extends JsonResource
{
    use RestApi;

    protected $code = '';
    protected $msg = '';
    function __construct($data, $code = '', $error = '')
    {
        $this->code = $code;
        $this->msg = $error;
        $this->resource = $data;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        $data['message'] = !empty($this->msg)?$this->msg:"";
        $data['statusCode'] = !empty($this->code)?$this->code:"200";
        $data['accessToken'] = $this->accessToken??"";
        return $this->jsonResponse($data);
    }

}
