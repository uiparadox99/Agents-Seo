<?php 
namespace App\Traits;
use Illuminate\Http\Response;

trait RestApi{

	public function jsonResponse($data)
	{
		$response = [];

		if(!empty($data['data']) || (isset($data['data']) && count($data['data']) != 0)){
			$response['data'] = $data['data'];
		}

		$response['version'] = "1.0.0";
		if(!empty($data['accessToken'])){
			$response['accessToken'] = $data['accessToken'];
		}

		$response['statusCode'] = isset($data['statusCode'])?$data['statusCode']:app('Illuminate\Http\Response')->status();

		switch ($response['statusCode']) {
			case 200:
				$response['status'] = true;
				break;
			case 201:
				$response['status'] = true;
				break;
			case 202:
				$response['status'] = true;
				break;
			case 203:
				$response['status'] = true;
				break;
			case 204:
				$response['status'] = true;
				break;
			
			default:
				$response['status'] = false;
				break;
		}

		if(!empty($data['message'])){
			$response['message'] = $data['message'];
		}else if(empty($data['message'])){
			switch ($response['statusCode']) {
				case 200:
					$response['message'] = trans('strings.code_200');		
					break;
				case 201:
					$response['message'] = trans('strings.code_201');		
					break;
				case 202:
					$response['message'] = trans('strings.code_202');		
					break;
				case 203:
					$response['message'] = trans('strings.code_203');		
					break;
				case 204:
					$response['message'] = trans('strings.code_204');		
					break;
				
				default:
					$response['message'] = trans('strings.default_error');
					break;
			}
		}
		return $response;
	}

}