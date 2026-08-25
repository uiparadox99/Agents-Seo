<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use App\TasksModels\City;
use App\Agents;
use App\TasksModels\Vendee;
use  App\Airlines as Airline;
use  App\Airlines as AirlineBlock;
use App\TasksModels\History;
use App\TasksModels\BlockedSeat;
use App\TasksModels\BlockedSeatRemark;
use DB;

class AjaxController extends Controller
{
    public function statusUpdater(Request $req)
    {
    	if ($req->type == 'airline_block_status') {
    		$status 			= $req->status;
    		$status_date_time 	= date("Y-m-d", strtotime($req->status_date))." ".$req->status_h.":".$req->status_m;

    		if(!empty($req->status_remarks_bk)){
    			$status_remarks = json_decode($req->status_remarks_bk);
    		}

    		if(!empty($req->status_remarks)){
    			$status_remarks[] = $req->status_remarks; 
    		}

    		$status_remarks = (!empty($status_remarks))? json_encode($status_remarks) : "";
    		if($status == "time_limit"){
    			$status_date_time = $status_date_time;
    		}else{
    			$status_date_time = null;
    		}

    		$a 						= AirlineBlock::where('id', $req->id)->first();
    		$a->status 				= $status;
    		$a->status_date_time 	= $status_date_time;
    		$a->status_remarks 		= $status_remarks;
    		$isSave 				= $a->save();

    		if ($isSave) {

    			$h 							= New History;
    			$h->airline_block_id 		= $req->id;
    			$h->admins_id 				= auth()->guard('admin')->user()->id;
    			$h->type 					= 'airline_block_status_update';
    			$h->activity_description 	= 'status updated to '.$status;
    			$h->remarks 				= $req->status_remarks;
    			$isSave 					= $h->save();
                
    			$response = array("status" => true, "message" => 'Operation completed successfully');
    			echo json_encode($response);
    		} else {
    			echo $response = json_encode(array("status" => false, "message" => 'Something went wrong, Try again'));
    		}
    	}
    }

    public function saveSeatBlock(Request $req)
    {
        $id     = $req->block_id;
        $type   = $req->type;
        $ab     = AirlineBlock::where('id', $id)->first();


        if (!empty($id) && $type == "edit")
        {
            $seats  = $ab->seats;
            if (!is_null($id))
            {
                $seat_no    = $req->seat_no;
                $seat_id    = $req->seat_id;
                $remark     = $req->remark;
                $balance    = $req->party_price - $req->advance;
                $partyName  = Vendee::where('id', $req->party_name_id)->first()->name;
                $insert     = false;

                $data = [
                    "seat_no"                   => $seat_no,
                    "admins_id"                 => auth()->guard('admin')->user()->id,
                    "airlineblockingdetails_id" => $id,
                    "passenger_name"            => strtoupper($req->passenger_name),
                    "party_price"               => $req->party_price,
                    "advance"                   => $req->advance,
                    "balance"                   => $balance,
                    "parties_id"                => $req->party_name_id,
                    "phone"                     => $req->phone,
                    "canNotEdit"                => 1
                ];

                if (empty($seat_id) || $seat_id == 0) {

                    $bs = BlockedSeat::where('seat_no', $seat_no)
                    ->where('airlineblockingdetails_id', $id)->first();

                    if (is_null($bs)) {

                        $data["booking_date"]   = date("Y-m-d");
                        $data["booking_time"]   = date("H:i:s");
                        $isBlockedSeat          = BlockedSeat::create($data);
                        $insert                 = true;

                    }else{

                        $name    = Agents::where('id', $bs->admins_id)->first()->name;
                        $notify  = $name." has already booked this seat.";
                        return response()->json(array("status" => false, "message" => $notify, "seat_id" => $seat_id, "insert"=> $insert));
                    }

                }else{

                    unset($data["admins_id"]);
                    $isBlockedSeat   = BlockedSeat::where('id', $seat_id)->update($data);
                    
                }

                if ($isBlockedSeat) {

                    $seat_id            = ($insert)?$isBlockedSeat->id:$seat_id;
                    $available_seats    = 0;
                    $action_type        = ($insert)?'blocked_seat_added':'blocked_seat_updated';
                    $action_type_text   = ($insert)?'added':'updated';

                    $history                        = New History;
                    $history->blocked_seat_id       = $seat_id;
                    $history->airline_block_id      = $id;
                    $history->admins_id             = auth()->guard('admin')->user()->id;
                    $history->type                  = $action_type;
                    $history->remarks               = $remark;
                    $history->data                  = json_encode($data);
                    $history->activity_description  = 'Seat no '.$seat_no." ".$action_type_text." by ".auth()->guard('admin')->user()->name;
                    $history->save();

                    if(!empty($remark) && !is_null($remark)){
                        $bsr                    = New BlockedSeatRemark;
                        $bsr->remarks           = $remark;
                        $bsr->blocked_seats_id  = $seat_id;
                        $bsr->type              = 'seat_update';
                        $bsr->remarks           = 'seat_update';
                        $bsr->admins_id         = auth()->guard('admin')->user()->id;
                        $bsr->save();
                    }

                    $booked_seats = BlockedSeat::where('admins_id', '<>', 0)
                    ->where('airlineblockingdetails_id', $id)
                    ->where('canNotEdit', 1)
                    ->where('isDeleted', 'yes')
                    ->get()->count();

                    if ($booked_seats) {
                        $available_seats = $seats - $ab->booked_seats;
                    }

                    $updateSeat = AirlineBlock::where('id', $id)
                    ->update(['available_seats' => $available_seats]);

                    if ($updateSeat) {
                        return response()->json(array("status" => true, "message" => "Operation completed successfully", "seat_id" => $seat_id, "insert"=> $insert));
                    }else{
                        return response()->json(array("status" => false, "message" => "Something went worng, Try again"));
                    }
                }else{
                    return response()->json(array("status" => false, "message" => "The selected record is empty in system."));
                }

            //end of 2nd if
            }
        //first if type check
        }elseif(isset($req->seat_id) && !empty($id) && $type == "clear"){
            
            $seat_no    = $req->seat_no;
            $seat_id    = $req->seat_id;
            $remark     = $req->remark;

            $data = [
                "admins_id"         => auth()->guard('admin')->user()->id,
                "passenger_name"    => "",
                "party_price"       => "",
                "advance"           => "",
                "balance"           => "",
                "phone"             => "",
                "canNotEdit"        => 0
            ];

            if (!empty($seat_id) && $seat_id > 0) {

                $bs                                 = BlockedSeat::where('id', $seat_id)->first();
                $backupBS                           = new BlockedSeat;
                $backupBS->seat_no                  = $bs->seat_no;
                $backupBS->admins_id                = $bs->admins_id;
                $backupBS->airlineblockingdetails_id = $bs->airlineblockingdetails_id;
                $backupBS->passenger_name           = $bs->passenger_name;
                $backupBS->party_price              = $bs->party_price;
                $backupBS->advance                  = $bs->advance;
                $backupBS->balance                  = $bs->balance;
                $backupBS->parties_id               = $bs->parties_id;
                $backupBS->phone                    = $bs->phone;
                $backupBS->remark                   = $bs->remark;
                $backupBS->canNotEdit               = $bs->canNotEdit;
                $backupBS->booking_date             = $bs->booking_date;
                $backupBS->isDeleted                = 'yes';
                $saveBackup                         = $backupBS->save();

                $isUpdate = BlockedSeat::where('id', $seat_id)->update($data);
                
            }

            if ($isUpdate) {

                $history                        = New History;
                $history->blocked_seat_id       = $seat_id;
                $history->airline_block_id      = $id;
                $history->admins_id             = auth()->guard('admin')->user()->id;
                $history->type                  = 'blocked_seat_reverted';
                $history->remarks               = $remark;
                $history->data                  = json_encode($data);
                $history->activity_description  = 'Seat no '.$seat_no." blocked_seat_reverted by ".auth()->guard('admin')->user()->name;
                $saveHistory                    = $history->save();


                if(!empty($remark) && !is_null($remark)){
                    $bsr                    = New BlockedSeatRemark;
                    $bsr->remarks           = $remark;
                    $bsr->blocked_seats_id  = $seat_id;
                    $bsr->type              = 'seat_update';
                    $bsr->remarks           = 'seat_update';
                    $bsr->admins_id         = auth()->guard('admin')->user()->id;
                    $bsr->save();
                }

                $available_seats            = $ab->available_seats + 1;

                $updateSeat = AirlineBlock::where('id', $id)
                ->update(['available_seats' => $available_seats]);

                if ($updateSeat) {
                    return response()->json(array("status" => true, "message" => "Operation completed successfully", "seat_id" => $seat_id));
                }else{
                    return response()->json(array("status" => false, "message" => "Something went worng, Try again"));
                }

            }else {
                return response()->json(array("status" => false, "message" => "Something went wrong, Try again")
            );
            }
        }else{
            return response()->json(array("status" => false, "message" => "The selected record is already empty in system."));
        }
    }

    public function validatePNR(Request $req)
    {
        if (!is_null($req->pnr)) {
           $exist = AirlineBlock::where('pnr', $req->pnr)->first();
            if (is_null($exist)) {
                $response = array("status" => true, "message" => "Unique PNR");
                return response()->json($response);
            } else {
                return response()->json(array("status" => false, "message" => "PNR already exist"));
            }
        } else{
            return response()->json(array("status" => false, "message" => "Something went wrong, Try again"));
        }
    }
}
