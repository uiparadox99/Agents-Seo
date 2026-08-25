<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\Agents;
use App\TasksModels\Vendee;
use App\TasksModels\Ticket;
use App\TasksModels\Invoice;
use App\TasksModels\Reservation;
use App\TasksModels\Permissions;
use App\TasksModels\PermissionHasAdmin;
use App\TasksModels\ACSectors;
use App\TasksModels\ACAirlines;
use PDF;
class ReservationController extends Controller
{
	public function index(Request $r)
	{
		 $invoices    = Reservation::whereNotNull('id');
		 if (!empty($r->code)) {
		 	 $invoices    = $invoices->where('code',$r->code);
		 }
		  if (!empty($r->date)) {
		 	 $invoices    = $invoices->whereDate('date_from','>=',date('Y-m-d',strtotime($r->date)));
		 }
		  if (!empty($r->date_to)) {
		 	 $invoices    = $invoices->whereDate('date_to','>=',date('Y-m-d',strtotime($r->date_to)));
		 }
		  if (!empty($r->passenger)) {
		 	 $invoices    = $invoices->where('passenger_name','LIKE','%'.$r->passenger.'%');
		 }
		 $data['invoices']    = $invoices->orderBy('date_from','DESC')->get();
		return view('user.tasks.reservation.index',$data);
	}
    public function generate(Request $r)
	{
		
		return view('user.tasks.reservation.generate');
	}

	public function save(Request $r)
	{
		$in  = new Reservation;
		$in->code = $r->code;
		$in->passenger_name = strtoupper($r->passenger_name);
		$in->airline_res_code = $r->airline_res_code;
		$in->date_from = date('Y-m-d',strtotime($r->date_from));
		$in->date_to = date('Y-m-d',strtotime($r->date_to));
/*		$in->total_ammount = $r->total;*/
		$in->data = json_encode($r->all());
		/*return view('pdf/invoice', $r->all());*/
		$in->save();
		Session::flash("success-msg", "Reservation Generated Successfully.");
		return redirect()->to('admin/manage-reservations');
		/*$pdf = PDF::loadView('pdf/invoice', $r->all());
		$name = $r->ref.' - invoice';
		return $pdf->download($name.'.pdf');*/
	}
	public function download($id)
	{	
		$in  = Reservation::find($id);
		$data = (array)json_decode($in->data);

		/*return view('pdf/reservation', $data);*/

		$pdf = PDF::loadView('pdf/reservation', $data);
		$name = 'Travel Reservation '.date('F d Y',strtotime($in->date_from)).' for '.strtoupper($in->passenger_name);
		return $pdf->download($name.'.pdf');
	}
	public function downloadAuto(Request $r)
	{
		$data = array();
		$pk = 0;
		$fk = 0;
		$pass = array();
		$flights = array();
		if (!empty($r->command)) {
			$lines = explode(PHP_EOL, $r->command);
			$classes = array(
				"A" => 'First Class',
				"B" => 'Economy',
				"C" => 'Business Class',
				"D" => 'Business Class',
				"E" => 'Shuttle Service',
				"F" => 'First Class',
				"G" => 'Conditional Reservation',
				"H" => 'Economy',
				"J" => 'Business Class Premium',
				"K" => 'Economy',
				"L" => 'Economy',
				"M" => 'Economy',
				"N" => 'Economy',
				"P" => 'First Class Premium',
				"Q" => 'Economy',
				"R" => 'First Class Suite',
				"S" => 'Economy/Coach',
				"T" => 'Economy',
				"U" => 'Shuttle Service',
				"V" => 'Economy',
				"W" => 'Economy Premium',
				"X" => 'Economy',
				"Y" => 'Economy/Coach',
				"Z" => 'Business Class'
			);
			$days = [
				"1" => 'Monday',
				"2" => 'Tuesday',
				"3" => 'Wednesday',
				"4" => 'Thursday',
				"5" => 'Friday',
				"6" => 'Saturday',
				"7" => 'Sunday'
			];
			$days_short = [
				"1" => 'Mon',
				"2" => 'Tue',
				"3" => 'Wed',
				"4" => 'Thu',
				"5" => 'Fri',
				"6" => 'Sat',
				"7" => 'Sun'
			];


			foreach ($lines as $key => $l) {
				if (!empty($l)) {
					if ($key == 0) {
						$data['reservation_code'] = $l;
					} else if (strpos($l, '.') !== false) {
						$l = explode('.', $l)[1];
						if (strpos($l, '*') !== false) {
							$name = explode('*', $l)[0];
							$type = explode('*', $l)[1];
							$name = str_replace('I/1', '', $name);
							$name = str_replace('1', '', $name);
							$name = preg_replace('/[0-9]+/', '', $name);

							$pass[$pk]['type'] = $type;
							$pass[$pk]['name'] = trim($name);
							$pk++;
						} else {
							$name = str_replace('I/1', '', $l);
							$name = str_replace('1', '', $name);
							$name = preg_replace('/[0-9]+/', '', $name);

							$pass[$pk]['type'] = 'ADT';
							$pass[$pk]['name'] = trim($name);
							$pk++;
						}
					} else {
						$wrf = explode(' ', $l);
						$wr = array();
						foreach ($wrf as $wf) {
							if (!empty($wf) && count($wrf) > 3) {
								$wr[] = $wf;
							}
						}
						if (isset($wr[5]) && strpos($wr[5], '*') == false) {
							unset($wr[6]);
							$wr = array_values($wr);
						}
						foreach ($wr as $wkey => $w) {
							if ($wkey == 1) {
								$flights[$fk]['airline_code'] = $w;
								$arl = ACAirlines::where('code', $w)->first();
								if (!is_null($arl)) {
									$flights[$fk]['airline'] = $arl->name;
								} else {
									$flights[$fk]['airline'] = '';
								}
							}
							if ($wkey == 2) {
								$cl_code = preg_replace('/[0-9]+/', '', $w);
								$fl_no = str_replace($cl_code, '', $w);
								for ($i = strlen($fl_no); $i < 4; $i++) {
									$fl_no = '0' . $fl_no;
								}
								$flights[$fk]['flight_no'] = $fl_no;


								$flights[$fk]['class_code'] = $cl_code;
								$flights[$fk]['class'] = isset($classes[$cl_code]) ? $classes[$cl_code] : $cl_code;
							}
							// if($wkey == 3){
							// 	$flights[$fk]['class_code'] = $w;
							// 	$flights[$fk]['class'] = $classes[$w];
							// }
							if ($wkey == 3) {

								$flights[$fk]['from_date'] = substr($w, 0, 2);
								$flights[$fk]['from_month'] = substr($w, 2, 3);
							}
							if ($wkey == 4) {
								$flights[$fk]['from_day'] = isset($days[$w]) ? $days[$w] : $w;
								$flights[$fk]['from_day_short'] = isset($days_short[$w]) ? $days_short[$w] : $w;
							}

							if ($wkey == 5) {
								if (strpos($w, '*') !== false) {
									$secA = explode('*', $w)[0];
								} else {
									$secA = $w;
								}
								$secA = str_replace('/', '', $secA);
								$sectors = str_split($secA, 3);
								$from_sec = $sectors[0];
								$to_sec = $sectors[1];
								$flights[$fk]['from_sec_code'] = $from_sec;
								$flights[$fk]['to_sec_code'] = $to_sec;
								$arl = ACSectors::where('code', $from_sec)->first();
								if (!is_null($arl)) {
									$flights[$fk]['from_sec'] = $arl->name;
								} else {
									$flights[$fk]['from_sec'] = '';
								}

								$arl = ACSectors::where('code', $to_sec)->first();
								if (!is_null($arl)) {
									$flights[$fk]['to_sec'] = $arl->name;
								} else {
									$flights[$fk]['to_sec'] = '';
								}
							}
							if ($wkey == 6) {
								$flights[$fk]['from_time'] = substr($w, 0, 2) . ':' . substr($w, 2, 4);
							}
							if ($wkey == 7) {

								$flights[$fk]['to_time'] = substr($w, 0, 2) . ':' . substr($w, 2, 4);
							}
							if (count($wr) > 10) {
								if ($wkey == 8) {
									$flights[$fk]['to_date'] = substr($w, 0, 2);
									$flights[$fk]['to_month'] = substr($w, 2, 3);
								}
								if ($wkey == 9) {
									$flights[$fk]['to_day'] = isset($days[$w]) ? $days[$w] : $w;
									$flights[$fk]['to_day_short'] = isset($days_short[$w]) ? $days_short[$w] : $w;
								}
								if ($wkey == 10) {
									$data['airline_res_code'] = explode('*', $w)[1];
									$flights[$fk]['reservation_code'] = explode('*', $w)[1];
								}
							} else {
								if ($wkey == 8) {
								    $airline_code_array = explode('*', $w);
								    if(is_array($airline_code_array) && count($airline_code_array) >= 2){
									  $data['airline_res_code'] = $airline_code_array[1];
								    }
								}
							}
						}

						if (isset($flights[$fk])) {
							$fk++;
						}
					}
				}
			}

			$data['pass'] = $pass;
			$data['flights'] = $flights;
			// return view('pdf/reservation-auto', $data);

			$pdf = PDF::loadView('pdf/reservation-auto', $data);
			$name = 'Travel Reservation ' . $flights[0]['from_date'] . ' ' . $flights[0]['from_month'] . ' 2022 for ' . strtoupper($pass[0]['name']);
			return $pdf->download($name . '.pdf');
		} else {
			return redirect()->back();
		}
	}
	public function QuotationAutoGenerate(Request $r)
	{
		$data = array();
		$pk = 0;
		$fk = 0;
		$pass = array();
		$flights = array();
		if (!empty($r->command)) {
			$lines = explode(PHP_EOL, $r->command);
			$classes = array(
				"A" => 'First Class',
				"B" => 'Economy',
				"C" => 'Business Class',
				"D" => 'Business Class',
				"E" => 'Shuttle Service',
				"F" => 'First Class',
				"G" => 'Conditional Reservation',
				"H" => 'Economy',
				"J" => 'Business Class Premium',
				"K" => 'Economy',
				"L" => 'Economy',
				"M" => 'Economy',
				"N" => 'Economy',
				"P" => 'First Class Premium',
				"Q" => 'Economy',
				"R" => 'First Class Suite',
				"S" => 'Economy/Coach',
				"T" => 'Economy',
				"U" => 'Shuttle Service',
				"V" => 'Economy',
				"W" => 'Economy Premium',
				"X" => 'Economy',
				"Y" => 'Economy/Coach',
				"Z" => 'Business Class'
			);
			$days = [
				"1" => 'Monday',
				"2" => 'Tuesday',
				"3" => 'Wednesday',
				"4" => 'Thursday',
				"5" => 'Friday',
				"6" => 'Saturday',
				"7" => 'Sunday'
			];
			$days_short = [
				"1" => 'Mon',
				"2" => 'Tue',
				"3" => 'Wed',
				"4" => 'Thu',
				"5" => 'Fri',
				"6" => 'Sat',
				"7" => 'Sun'
			];


			foreach ($lines as $key => $l) {
				if (!empty($l)) {
					
						$wrf = explode(' ', $l);
						$wr = array();
						foreach ($wrf as $wf) {
							if (!empty($wf) && count($wrf) > 3) {
								$wr[] = $wf;
							}
						}
						if (isset($wr[5]) && strpos($wr[5], '*') == false) {
							unset($wr[6]);
							$wr = array_values($wr);
						}
						foreach ($wr as $wkey => $w) {
							if ($wkey == 1) {
								$flights[$fk]['airline_code'] = $w;
								$arl = ACAirlines::where('code', $w)->first();
								if (!is_null($arl)) {
									$flights[$fk]['airline'] = $arl->name;
								} else {
									$flights[$fk]['airline'] = '';
								}
							}
							if ($wkey == 2) {
								$cl_code = preg_replace('/[0-9]+/', '', $w);
								$fl_no = str_replace($cl_code, '', $w);
								for ($i = strlen($fl_no); $i < 4; $i++) {
									$fl_no = '0' . $fl_no;
								}
								$flights[$fk]['flight_no'] = $fl_no;


								$flights[$fk]['class_code'] = $cl_code;
								$flights[$fk]['class'] = isset($classes[$cl_code]) ? $classes[$cl_code] : $cl_code;
							}
							// if($wkey == 3){
							// 	$flights[$fk]['class_code'] = $w;
							// 	$flights[$fk]['class'] = $classes[$w];
							// }
							if ($wkey == 3) {

								$flights[$fk]['from_date'] = substr($w, 0, 2);
								$flights[$fk]['from_month'] = substr($w, 2, 3);
							}
							if ($wkey == 4) {
								$flights[$fk]['from_day'] = isset($days[$w]) ? $days[$w] : $w;
								$flights[$fk]['from_day_short'] = isset($days_short[$w]) ? $days_short[$w] : $w;
							}

							if ($wkey == 5) {
								if (strpos($w, '*') !== false) {
									$secA = explode('*', $w)[0];
								} else {
									$secA = $w;
								}
								$secA = str_replace('/', '', $secA);
								$sectors = str_split($secA, 3);
								$from_sec = $sectors[0];
								$to_sec = $sectors[1];
								$flights[$fk]['from_sec_code'] = $from_sec;
								$flights[$fk]['to_sec_code'] = $to_sec;
								$arl = ACSectors::where('code', $from_sec)->first();
								if (!is_null($arl)) {
									$flights[$fk]['from_sec'] = $arl->name;
								} else {
									$flights[$fk]['from_sec'] = '';
								}

								$arl = ACSectors::where('code', $to_sec)->first();
								if (!is_null($arl)) {
									$flights[$fk]['to_sec'] = $arl->name;
								} else {
									$flights[$fk]['to_sec'] = '';
								}
							}
							if ($wkey == 6) {
								$flights[$fk]['from_time'] = substr($w, 0, 2) . ':' . substr($w, 2, 4);
							}
							if ($wkey == 7) {

								$flights[$fk]['to_time'] = substr($w, 0, 2) . ':' . substr($w, 2, 4);
							}
							if (count($wr) > 10) {
								if ($wkey == 8) {
									$flights[$fk]['to_date'] = substr($w, 0, 2);
									$flights[$fk]['to_month'] = substr($w, 2, 3);
								}
								if ($wkey == 9) {
									$flights[$fk]['to_day'] = isset($days[$w]) ? $days[$w] : $w;
									$flights[$fk]['to_day_short'] = isset($days_short[$w]) ? $days_short[$w] : $w;
								}
								if ($wkey == 10) {
									$data['airline_res_code'] = explode('*', $w)[1];
									$flights[$fk]['reservation_code'] = explode('*', $w)[1];
								}
							} else {

								if ($wkey == 8) {
									$data['airline_res_code'] = explode('*', $w)[1];
								}
							}
						}

						if (isset($flights[$fk])) {
							$fk++;
						}
					
				}
			}
			$data['price'] = $r->all();
			$data['flights'] = $flights;
			// return view('pdf/quotation-auto', $data);

			$pdf = PDF::loadView('pdf/quotation-auto', $data);
			$name = 'Travel Quotation ' . $flights[0]['from_date'] . ' ' . $flights[0]['from_month'] . ' 2022';
			return $pdf->download($name . '.pdf');
		} else {
			return redirect()->back();
		}
	}
}
