@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@push("style")
<style>
    label{
        text-align: center !important;
    }

    .seats-booking-table-wrapper th{
        text-align: center;
        padding: 5px 3px !important;
    }

    .seats-booking-table{
        margin-bottom: 0px;
    }

    .seats-booking-table td{
        text-align: center;
        border-top: 1px solid transparent !important;
    }

    .seats-booking-table td:nth-child(2), .seats-booking-table td:nth-child(8){
        text-align: left !important;
    }

    .seats-booking-table td,.seats-booking-table td .form-control{
        padding: 3px;
    }
    
    .passenger_name{
        text-transform: uppercase;
    }
    
    .input-group{
        width: 100%;
    }
    
    .modal-dialog{
        width: 850px !important;
    }
    
    .flight-detail-table{
        display: inline-block;
        width: 900px;
    }
    
    .flight-detail-table td{
        padding-right: 50px;
    }
</style>
@endpush
@section('content')


<div class="container">
   <section class="content-header">
      <h1>
         Add Airline Block
      </h1>
      <ol class="breadcrumb">
         <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Airline Block</li>
      </ol>
   </section>
   <section class="content add-seats-blocking">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title" style="font-size: 16px;">
               <table class='flight-detail-table'>
                  <tr>
                     <td>
                        <?php echo "<strong style='color: blue;'>".$r->pnr."</strong>" ; ?>
                     </td>
                     <td>
                        <?php if(!empty($r->logo)){ ?>
                        <img src="uploads/<?php echo $r->logo; ?>" class="" style="width: 100px;"/>
                        <?php }else{ ?>
                        <?php echo $r->airline; ?>
                        <?php } ?> 
                     </td>
                     <td><?php echo $r->flight_number; ?></td>
                     <td><b style='color: #00a65a;'><?php echo $r->from_city." - ".$r->to_city ; ?></b></td>
                     <td><b style='color: red;'><?php echo date("d-M-Y",strtotime($r->out_bound_date)) ; ?></b></td>
                     <td><?php echo date("H:i", strtotime($r->one_way_departure_time))." - ".date("H:i", strtotime($r->one_way_arrival_time)); ?></td>
                  </tr>
                  <?php if($r->one_way_or_return){ ?>
                  <tr>
                     <td colspan="2"></td>
                     <td><?php echo $r->extra_r_flight_code1; ?></td>
                     <td><b style='color: #00a65a;'><?php echo $r->to_city." - ".$r->from_city ; ?></b></td>
                     <td><b style='color: red;'><?php echo date("d-M-Y",strtotime($r->in_bound_date)) ; ?></b></td>
                     <td><?php echo date("H:i", strtotime($r->return_departure_time))." - ".date("H:i", strtotime($r->return_arrival_time)); ?></td>
                  </tr>
                  <?php } ?>
               </table>
            </h3>
            <div class="box-tools pull-right">
               <a href="javascript: void(0)" data-toggle="modal" data-target="#extraDetailModal" class="btn btn-primary">Extra Details</a>
               <a href="export-passenger-list-details.php?id=" class="btn btn-warning" target="_blank"><i class="fa fa-download"></i> Export</a>
               <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-12">
                  <table class="table seats-booking-table-wrapper">
                     <tr>
                        <th width="3%">#</th>
                        <th width="20%">Passenger Name</th>
                        <th width="5%">Price</th>
                        <th width="5%">Received</th>
                        <th width="5%">Balance</th>
                        <th width="17%">Party Name</th>
                        <th width="10%">Phone</th>
                        <th width="19%">Remarks</th>
                        <th width="9%">Booked By</th>
                        <th width="7%"></th>
                     </tr>
                     <tr>
                        <td style="padding: 0;" colspan="10">
                           @php
                           for ($i = 0; $i < $r->seats; $i++) { 
                           $remarksData  = json_encode([]);
                           $seatCurrent  = $i + 1;
                           $seatData     = [];
                           $seatRemarks  = '';
                           
                           foreach($d as $ds){
                           if($ds["seat_no"] == $seatCurrent){
                              $seatData = $ds;
                            }
                             $remarksData = json_encode($ds->remarks);
                           }

                           @endphp
                           <form class="validation-form">
                            
                              <table class="table table-bordered <?php echo ($i%2 == 0)?"table-striped":"";?> table-hover seats-booking-table">
                                 <tr>
                                    <td class="text-center" width="3%">
                                       <?php echo $seatCurrent; ?>
                                       <input type="hidden" name="canNotEdit" value="" />
                                       <input type="hidden" name="seat_no" value="<?php echo $seatCurrent; ?>" />
                                       <input type="hidden" name="seat_id" class="seat_id" value="{{ $seatData->id??'' }}" />
                                    </td>
                                    <td width="20%" class="passenger_name <?php echo (strtolower((isset($seatData["passenger_name"])?$seatData["passenger_name"]:"")) == "hold")?"holdPessengar":""; ?>">
                                       <input type="text" class="form-control validate[required]" name="passenger_name" value="<?php echo strtoupper((isset($seatData["passenger_name"])?$seatData["passenger_name"]:"")); ?>"/>
                                       <span></span>
                                    </td>
                                    <input type="hidden" name="block_id" value="{{ $id }}">
                                    <td width="5%">
                                       <input type="text" class="form-control validate[required, custom[integer]] price-field" name="party_price" value="<?php echo (isset($seatData["party_price"])?$seatData["party_price"]:""); ?>"/>
                                       <span></span>
                                    </td>
                                    <td width="5%">
                                       <input type="text" class="form-control validate[required, custom[integer]] advance-field" name="advance" value="<?php echo (isset($seatData["advance"])?$seatData["advance"]:""); ?>"/>
                                       <span></span>
                                    </td>
                                    <td width="5%" <?php echo ((isset($seatData["balance"])?$seatData["balance"]:"") > 0) ? 'style="color: red;"' : "" ; ?> class="balance">
                                       <?php echo (isset($seatData["balance"])?$seatData["balance"]:""); ?>
                                    </td>
                                    <td width="17%">
                                       <select class="form-control select2 party" name="party_name_id">
                                          <option value="">Select</option>
                                          
                                             @foreach ($pnData as $k => $pn)
                                             @php
                                             $s = isset($seatData["parties_id"]) && $pn->id == $seatData["parties_id"]?'selected':'';
                                             @endphp
                                             <option {{ $s }} value="{{ $pn->id }}" 
                                              data-phone="{{ $pn->phone }}">
                                              {{ $pn->name }}
                                            </option>
                                          @endforeach
                                       </select>
                                       <span></span>
                                    </td>
                                    <td width="10%">
                                       <input type="text" data-inputmask='"mask": "9999-9999999"' data-mask class="form-control validate[required, funcCall[checkPhone]]" name="phone" value="<?php echo (isset($seatData["phone"])?$seatData["phone"]:""); ?>"/>
                                       <span></span>
                                    </td>
                                    <td width="19%" class="can-change">
                                       <input type="hidden" name="remark_existing" value="<?php echo (isset($seatData["remark"])?$seatData["remark"]:""); ?>" />
                                       <div class="input-group">
                                          <input type="text" class="form-control remark" name="remark" value=""/>
                                          <a class="input-group-addon show-old-remarks" href="javascript: void(0);" data-remarks='<?php echo $remarksData; ?>' data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i></a>
                                       </div>
                                       <span></span>
                                    </td>
                                    <td width="9%" class="user_name">
                                       <?php echo (isset($seatData["user_name"])?$seatData["user_name"]:""); ?>
                                       <?php echo ((isset($seatData["booking_date"])?$seatData["booking_date"]:"") != "0000-00-00" && (isset($seatData["booking_date"])?$seatData["booking_date"]:"") != "")?"<br/>".date("d-M-Y",  strtotime((isset($seatData["booking_date"])?$seatData["booking_date"]:""))):""; ?>
                                    </td>
                                    <td class="text-center" width="7%">
                                       <a href="javascript: void(0);" class="saveRecord" style="<?php echo ((isset($seatData["admins_id"])?$seatData["admins_id"]:"") != 0)? "color:red":"";?>"><i class="fa fa-save fa-2x"></i></a>
                                       <a href="javascript: void(0);" class="clearSeat"><i class="fa fa-undo fa-2x"></i></a>
                                    </td>
                                 </tr>
                              </table>
                           </form>
                           <?php } ?>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
            <div style="font-size: 18px;">
               @php
                 if (is_null($dat)) {
                 $total_price = 0;
                 $received    = 0;
                 $cost        = 0;
                 }else{ 
                 $total_price = $dat->total_price;
                 $received    = $dat->received;
                 $cost        = $r->cost_price * $r->seats;
                 }
               @endphp
               <div class="row">
               </div>
               <div class="row">
                  <div class="col-md-2">
                     Total
                  </div>
                  <div class="col-md-2">
                     <strong>RS <?php echo $total_price ; ?></strong>
                  </div>
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-2">
                     Selling
                  </div>
                  <div class="col-md-2">
                     <strong>RS <?php echo $total_price ; ?></strong>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-2">
                     Received
                  </div>
                  <div class="col-md-2">
                     <strong>RS <?php echo $received ; ?></strong>
                  </div>
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-2">
                     Cost
                  </div>
                  <div class="col-md-2">
                     <strong>RS <?php echo $cost ; ?></strong>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-2">
                     Balance
                  </div>
                  <div class="col-md-2">
                     <strong style='color: red;'>RS <?php echo $total_price - $received?></strong>
                  </div>
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-2">
                     Profit
                  </div>
                  <div class="col-md-2">
                     <strong style="color: blue;">RS <?php echo $total_price - $cost ; ?></strong>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="box box-default collapsed-box">
         <div class="box-header with-border">
            <h3 class="box-title" style="font-size: 16px;">History</h3>
            <div class="box-tools pull-right">
               <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
            <div class="row">
               <div class="col-md-12">
                  <table class="table table-bordered table-striped datatables">
                     <thead>
                        <tr>
                           <th width="5%">Sr #</th>
                           <th width="30%">Activity</th>
                           <th width="10%">Passengar</th>
                           <th width="10%">Party</th>
                           <th width="5%">Phone #</th>
                           <th width="5%">Price</th>
                           <th width="5%">Advance</th>
                           <th width="5%">Balance</th>
                           <th width="20%">Remarks</th>
                           <th width="10%">Performed On</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $no = 1;
                          foreach($bookingHistory as $h){
                          $d = json_decode($h->data);
                        ?>
                        <tr>
                           <td><?php echo $no;?></td>
                           <td>{{ str_replace('_', ' ', $h->activity_description) }}</td>
                           <td>{{ $d->passenger_name??'' }}</td>
                           <td>{{ $d->party_name??'' }}</td>
                           <td>{{ $d->phone??'' }}</td>
                           <td>{{ $d->party_price??'' }}</td>
                           <td>{{ $d->advance??'' }}</td>
                           <td>{{ $d->balance??'' }}</td>
                           <td>{{ $h->remarks }}</td>
                           <td>{{ date("d-m-Y H:i", strtotime($h->performedOn)) }}</td>
                        </tr>
                        <?php 
                           $no++;
                           } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Old Remarks</h4>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-lg-12" id="remarks"></div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="extraDetailModal" tabindex="-1" role="dialog" aria-labelledby="extraDetailModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="extraDetailModalLabel" style="text-align: center">Extra Flight Detail</h4>
            <?php echo "<strong style='color: blue;'>".$r->pnr."</strong>&emsp;&emsp;&emsp;&emsp;" ; ?>
            <?php if(!empty($r->logo)){ ?>
            <img src="uploads/<?php echo $r->logo; ?>" class="" style="width: 100px;"/>
            <?php }else{ ?>
            <?php echo $r->airline; ?>
            <?php } ?>                                
         </div>
         <div class="modal-body">
            <form class="form-horizontal">
               <div class="row">
                  <div class="col-md-6">
                     <?php                       
                        echo "<b style='color: #00a65a;'>".$r->from_city." - ".$r->to_city."</b>&emsp;&emsp;<b style='color: red;'>".date("d-M-Y",strtotime($r->out_bound_date))."</b>";
                        $outbound = $r->out_bound_date;
                        $whichDay = ($r->extra_trancend_date != "next")? $outbound : date('Y-m-d', strtotime($outbound . ' +1 day')); 
                        $first = new DateTime($outbound." ".$r->extra_one_way_arrival_time1);
                        $diff = $first->diff(new DateTime($whichDay." ".$r->extra_one_way_departure_time2));
                        $transentTime = (($diff->h < 10)? "0".$diff->h :$diff->h) .":".(($diff->i < 10)? "0".$diff->i:$diff->i);
                        ?>
                     <br/><br/>
                     <h4 style="margin-top: 0;">One Way  <span style="color: red;">(<?php echo $transentTime; ?>)</span></h4>
                     <div class="form-group">
                        <div class="col-md-4"><?php echo $r->extra_flight_code1 ; ?></div>
                        <div class="col-md-8"><span style="color: red;"><?php echo $r->extra_from_1 ; ?> - <?php echo $r->extra_to_1 ; ?></span></div>
                     </div>
                     <div class="form-group">
                        <div class="col-md-3">Departure</div>
                        <div class="col-md-3"><?php echo date("H:i", strtotime($r->extra_one_way_departure_time1)) ; ?></div>
                        <div class="col-md-3">Arrival</div>
                        <div class="col-md-3"><?php echo date("H:i", strtotime($r->extra_one_way_arrival_time1)) ; ?></div>
                     </div>
                     <div class="form-group">
                        <div class="col-md-4"><?php echo $r->extra_flight_code2 ; ?></div>
                        <div class="col-md-8"><span style="color: blue;"><?php echo $r->extra_from_2 ; ?> - <?php echo $r->extra_to_2 ; ?></span></div>
                     </div>
                     <div class="form-group">
                        <div class="col-md-3">Departure</div>
                        <div class="col-md-3"><?php echo date("H:i", strtotime($r->extra_one_way_departure_time2)) ; ?></div>
                        <div class="col-md-3">Arrival</div>
                        <div class="col-md-3"><?php echo date("H:i", strtotime($r->extra_one_way_arrival_time2)) ; ?></div>
                     </div>
                  </div>
                  <?php 
                     $inbound = $r->in_bound_date;
                     $whichDay = ($r->extra_r_trancend_date != "next")? $inbound :date('Y-m-d', strtotime($inbound . ' +1 day')); 
                     $first = new DateTime($inbound." ".$r->extra_return_arrival_time1);
                     $diff = $first->diff(new DateTime($whichDay." ".$r->extra_return_departure_time2));
                     $transentTime = (($diff->h < 10)? "0".$diff->h :$diff->h) .":".(($diff->i < 10)? "0".$diff->i:$diff->i);
                     ?>
                  <div class="col-md-6" style="border-left:1px solid #d2d6de; <?php echo ($r->in_bound_date == "1970-01-01")? "display:none" : "" ; ?>">
                     <?php 
                        if($r->one_way_or_return){
                            echo "<b style='color: #00a65a;'>".$r->to_city." - ".$r->from_city."</b>&emsp;&emsp;<b style='color: blue;'>".date("d-M-Y",strtotime($r->in_bound_date))."</b>";
                        }
                        ?>
                     <br/><br/>
                     <h4 style="margin-top: 0;">Return <span style="color: red;">(<?php echo $transentTime; ?>)</span></h4>
                     <div class="form-group">
                        <div class="col-md-4"><?php echo $r->extra_r_flight_code1 ; ?></div>
                        <div class="col-md-8"><span style="color: red;"><?php echo $r->extra_r_from_1 ; ?> - <?php echo $r->extra_r_to_1 ; ?></span></div>
                     </div>
                     <div class="form-group">
                        <div class="col-md-3">Departure</div>
                        <div class="col-md-3"><?php echo date("H:i", strtotime($r->extra_return_departure_time1)) ; ?></div>
                        <div class="col-md-3">Arrival</div>
                        <div class="col-md-3"><?php echo date("H:i", strtotime($r->extra_return_arrival_time1)) ; ?></div>
                     </div>
                     <div class="form-group">
                        <div class="col-md-4"><?php echo $r->extra_r_flight_code2 ; ?></div>
                        <div class="col-md-8"><span style="color: blue;"><?php echo $r->extra_r_from_2 ; ?> - <?php echo $r->extra_r_to_2 ; ?></span></div>
                     </div>
                     <div class="form-group">
                        <div class="col-md-3">Departure</div>
                        <div class="col-md-3"><?php echo date("H:i", strtotime($r->extra_return_departure_time2)) ; ?></div>
                        <div class="col-md-3">Arrival</div>
                        <div class="col-md-3"><?php echo date("H:i", strtotime($r->extra_return_arrival_time2)) ; ?></div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

@endsection
@push('script')

<script>
    $(document).ready(function() {

        $(document).on('focus', '.select2', function() {
            $(this).siblings('select').select2('open');
        });

        $(".party").change(function() {
            var phone = $(this).find("option:selected").attr("data-phone");
            if (phone.length && $(this).parents("td").next().find("input[data-mask]").val().length) {
                if (confirm("Do you want to replace phone number with save party phone number?")) {
                    $(this).parents("td").next().find("input[data-mask]").val(phone);
                }
            } else if (phone.length && !$(this).parents("td").next().find("input[data-mask]").val().length) {
                $(this).parents("td").next().find("input[data-mask]").val(phone);
            }
        });

        $('.show-old-remarks').click(function() {

            var remarks = JSON.parse($(this).attr('data-remarks'));

            if (remarks.length) {

                var html = "<ol>";
                for (var i = 0; i < remarks.length; i++) {
                    html += "<li>" + remarks[i].name + " (" + remarks[i].datetime + ") : " + remarks[i].remarks + " </li>";
                }
                html += "</ol>";

            } else {
                var html = "No Remarks Added Before";
            }
            $('#remarks').html(html);
        });

        $(".advance-field, .price-field").keydown(function(e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        $(".advance-field, .price-field").blur(function() {
            var $tr = $(this).closest("tr");
            if ($tr.find(".advance-field").val().length) {
                var advance = parseInt($tr.find(".advance-field").val());
            } else {
                var advance = 0;
            }

            if ($tr.find(".price-field").length) {
                var party_price = parseInt($tr.find(".price-field").val());
            } else {
                var party_price = 0;
            }
            var balance = party_price - advance;
            if (!isNaN(balance)) {
                $tr.find(".balance").text(balance);
                if (balance > 0) {
                    $tr.find(".balance").css("color", "red");
                } else {
                    $tr.find(".balance").css("color", "black");
                }
            }
        });

        $(".saveRecord").click(function() {
            var $this     = $(this);
            var $tr       = $this.closest("tr");
            var formData  = $this.closest("tr").find("input, select").serialize();
            console.log(formData);
            $.ajax({
                url: "{{ url('admin/seats-blocking-ajax') }}?&type=edit",
                type: "GET",
                dataType: "JSON",
                data: formData,
                beforeSend: function() {
                    BusyIndicator(true, "Saving...");
                },
                success: function(resp) {
                    if (resp.status) {

                        window.location.reload();

                        $this.css("color", "red");
                        $tr.find(".seat_id").val(resp.seat_id);
                        if (resp.insert) {
                            $tr.find("td.user_name").text("{{ auth()->guard('admin')->user()->name }}");
                        }
                        $tr.find(".remark").val("");
                        $tr.find("td").each(function() {
                            if (!$(this).hasClass("can-change") && !$(this).is(":last-child")) {
                              
                                if ($(this).find("input[type=text]").length) {
                                    $(this).find("span").html($(this).find("input[type=text]").val());
                                    $(this).find("input[type=text]").hide();
                                }
                                if ($(this).find("select").length) {
                                    $(this).find("span").html($(this).find("select option:selected").text());
                                    $(this).find("select").hide();
                                }
                            }
                        });

                    } else {
                        alert(resp.message);
                    }
                },
                complete: function() {
                    BusyIndicator(false);
                }
            });
        });

        $(".clearSeat").click(function() {
            var $this = $(this);
            var $tr = $this.closest("tr");
            $tr.find(".remark").addClass("validate[required]");

            if (!confirm("Are you sure?")) {
                return false;
            }

            var formData = $this.closest("tr").find("input, select").serialize();
            $.ajax({
                url: "{{ url('admin/seats-blocking-ajax') }}?type=clear",
                type: "GET",
                dataType: "JSON",
                data: formData,
                beforeSend: function() {
                    BusyIndicator(true, "Saving...");
                },
                success: function(resp) {
                    if (resp.status) {
                        window.location.reload();

                    } else {
                        alert(resp.message);
                    }
                },
                complete: function() {
                    BusyIndicator(false);
                }
            });
        });
    });

</script>
@endpush