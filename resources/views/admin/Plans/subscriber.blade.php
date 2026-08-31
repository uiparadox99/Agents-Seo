@extends('admin.layout.master')
@section('title', 'Subscription')
@section('pageTitle', 'Manage Subscription')
@section('pageTitleSub', 'Manage')
@section('content')
<?php $GeneralClasses = 'form-control'; 
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Subscription
            @if($action=="add")<small>Add </small>@endif
            @if($action=="edit")<small>Modify </small>@endif
            @if($action=="renewal")<small>Renewal </small>@endif
            @if($action=="upgrade")<small>UpGrade </small>@endif
            @if($action=="downgrade")<small>DownGrade </small>@endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Subscription</li>
        </ol>
    </section>



    <section class="content">
        <?php $d = !empty($modal)? $modal : ""; ?>
        {!! Form::model($modal, array('route' => array('admin.save-subscription', !empty($modal)?$d->id:"0",
        !is_null($action)?$action:"add"), 'class'=>'form-horizontal form-validation', 'id'=>'subscribe',
        'enctype'=>'multipart/form-data')) !!}
        <input type="hidden" id="expairy_date_custom_input" name="expire_date" value="{{!empty($modal)?$d->expairy_date:''}}" >
        <div class="row" id="addSubscriber">
            <!-- right column -->
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            @if($action=="add")<span class="text-red">Add Agent Subscription </span>@endif
                            @if($action=="edit")<span class="text-red">Modify Agent Subscription </span>@endif
                            @if($action=="renewal")<span class="text-red">Renewal Agent Subscription </span>@endif
                            @if($action=="upgrade")<span class="text-red">UpGrade Agent Subscription </span>@endif
                            @if($action=="downgrade")<span class="text-red">DownGrade Agent Subscription </span>@endif
                            <strong class="text-blue">
                                @if(!empty($d))
                                @foreach($agents as $a)
                                {{$a->business_name}}
                                @endforeach
                                @endif
                            </strong>
                        </h3>
                        <button type="submit" class="btn btn-info pull-right" id="saveSubscriber">Save</button>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <div class="box-body">
                        <div class="col-md-5 col-md-offset-1">
                            <div class="form-group">
                                <label for="designation_for" class="col-sm-4 control-label1">Active</label>
                                <div class="col-sm-4 ">
                                    <div class="segmented-control" style="width: 100%; color: #337AB7">
                                         <label for="Enable" data-value="Enable"> {!! Form::radio('isActive', 1,!isset($modal) || $modal->active == 1?true:false, ["id"=>"Enable"]); !!} Enable</label>
                                         <label for="Disable" data-value="Disable"> {!! Form::radio('isActive', 0, isset($modal) && $modal->active == 0?true:false, ["id"=>"Disable"]); !!}
                                      
                                      Disable</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label1">Agent</label>
                                <div class="col-sm-8">
                                    <select name="agent_id" id="agent_id" class="form-control select2 validate[required]">

                                        @foreach($agents as $a)
                                        <option value="{{$a->id}}" data-period="{{isset($a->period)?$a->period:0}}"
                                            plan-id="{{isset($a->plan_id)?$a->plan_id:0}}"
                                            {{!empty($modal)?$d->agent->id == $a->id?"selected":"":""}}>
                                            {{$a->business_name}} ({{$a->city}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if(empty($modal) && empty($d->id))
                            <div class="form-group">
                                <label for="designation_for" class="col-sm-4 control-label1">Plans</label>
                                <div class="col-sm-8">
                                    <select name="plan_id" id="plan_id" class="form-control validate[required]">
                                        @foreach($plans as $p)
                                              @if($p->id != 5 )
                                            <option value="{{$p->id}}" id="{{$p->id}}"
                                                {{!empty($modal)?$d->plan_id == $p->id?"selected":"":""}}>{{$p->name}}
                                            </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="plan_id" value="{{$d->plan_id}}">
                            @endif
                            <div class="form-group">
                                <label for="designation_for" class="col-sm-4 control-label1">Period </label>
                                <div class="col-sm-8">
                                    <select name="period" id="period" class="form-control validate[required]"
                                        data-toggle="tooltip" title="" data-widget="chat-pane-toggle"
                                        data-original-title="Period Count From Current Date">
                                        @for($i = 1; $i<=2; $i++) <option value="{{$i}}" id="{{$i}}"
                                            {{!empty($modal)?$d->period == $i?"selected":"":""}}> {{$i}} Year</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>
                          <!--   <div class="form-group">
                                <label for="designation_for" class="col-sm-4 control-label1">Company Account
                                    Title</label>
                                <div class="col-sm-8">
                                    <select name="company_account_title" id="receiver_account_title"
                                        class="form-control validate[required]">
                                        <option value="">Select Account Title</option>
                                        @foreach($company_accounts as $ca)
                                        <option value="{{$ca->account_title}}"
                                            {{!empty($modal)? ($d->receiver_account_title == $ca->account_title) ? "selected" : "" : ""}}>
                                            {{$ca->account_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="designation_for" class="col-sm-4 control-label1">Sender Account
                                    Title</label>
                                <div class="col-sm-8">
                                    {!! Form::text("sender_account_title", null, ['class'=>'validate[required]
                                    '.$GeneralClasses, 'placeholder'=>'Sender Account Title']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="designation_for" class="col-sm-4 control-label1">Sender Account
                                    Number</label>
                                <div class="col-sm-8">
                                    {!! Form::text("sender_account_number", null, ['class'=>'validate[required]
                                    '.$GeneralClasses, 'placeholder'=>'Sender Account Number']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="designation_for" class="col-sm-4 control-label1">Sender Bank Name</label>
                                <div class="col-sm-8">
                                    {!! Form::text("sender_bank_name", null, ['class'=>'validate[required]
                                    '.$GeneralClasses, 'placeholder'=>'Sender Bank Name']) !!}
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="designation_for" class="col-sm-4 control-label1">Payment Status</label>
                                <div class="col-sm-8">
                                    {!! Form::select("status", array('unpaid' => 'UnPaid','paid' => 'Paid' ), null,['class'=>'validate[required] '.$GeneralClasses,
                                    'id'=>"payment_status"]) !!}
                                </div>
                            </div>
                        </div> <!-- END Div Col-md-5 -->
                        <div class="col-md-5">
                            <!-- <h4 class="box-title text-blue"><strong>Subscription Detail</strong></h4>
                    <hr> -->
                            <table class="table">
                              <!--   <tr>
                                    <th width="38%">Plan Price</th>
                                    <td>
                                        <h3 class="box-title text-blue" style="margin: 0"><strong
                                                id="plan_price">&nbsp;</strong></h3>
                                    </td>
                                </tr> -->
                              <!--   <tr>
                                    <th>Discounted Price</th>
                                    <td>
                                        <h3 class="box-title text-blue" style="margin: 0"><strong
                                                id="discount_price">&nbsp;</strong></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Remaining Price</th>
                                    <td>
                                        <h3 class="box-title text-blue" style="margin: 0"><strong
                                                id="remainingAmount">&nbsp;</strong></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Calculate Price <br> <small style="font-size:10px;" class="text-red">(Price *
                                            Period) - Remaining Price</small></th>
                                    <td>
                                        <h3 class="box-title text-blue" style="margin: 0"><strong
                                                id="orignal_price">&nbsp;</strong></h3>
                                    </td>
                                </tr> -->
                                <input type="hidden" name="payment" value="{{!empty($modal)?$d->payment:''}}" id="payment_price" >
                                <tr>
                                    <th>Total Amount</th>
                                    <td valign="top">
                                        @if(!empty($modal))
                                           <h1 class="box-title text-red" style="margin: 0"  id="price_cutome"><strong
                                              >&nbsp;</strong><small>Rs </small> {{!empty($modal)?$d->payment:'2000'}}</h1>
                                        @else
  <h1 class="box-title text-red" style="margin: 0" id="price_cutome"><strong
                                              >&nbsp;</strong><small>Rs </small> 2000</h1>
                                        @endif
                                      

                                               
                                    </td>
                                </tr>
                                  @if(!empty($modal) && !empty($d->plan_name) )
                                             <tr class="expire">
                                    <th>Plan</th>
                                    <td><strong > {{$d->plan_name}}</strong></td>
                                </tr>
                                          @endif
                                <tr class="expire">
                                    <th>Expire at</th>
                                    <!-- <td><small class="text-blue"><strong id="expire_date"></strong></small></td> -->
                        
                                    <td id="expairy_date_custom">{{!empty($modal)?date('d M Y',strtotime($d->expairy_date)):''}}</td>
                                </tr>
                                @if(!empty($modal))
                                 <tr class="expire">
                                    <th>Current Payment Status</th>
                                    <td><strong id="expire_date"> {{$d->payment_status}}</strong></td>
                                </tr>
                                @endif
                                        
                             <!--    <tr>
                                    <th>
                                        <h4><strong class="text-red">Received Payment: &nbsp; RS.</strong></h4>
                                    </th>
                                    <td>{!! Form::text("receive_payment", null, ['class'=>$GeneralClasses,
                                        'placeholder'=>'Received Payment', "id"=>"received_payment"]) !!}</td>
                                </tr> -->
                            <!--     <tr>
                                    <th>Payment Status</th>
                                    <td valign="top">
                                        <h3 class="box-title text-red" style="margin: 0"><strong
                                                id="status">&nbsp;</strong></h3>
                                    </td>
                                </tr> -->
                            </table>
                        </div>
                        <div class="col-md-10 col-md-offset-1">
                            <hr>
                            <div class="form-group">
                                <label for="designation_for" class="col-sm-4 control-label1">Comment</label>
                                <div class="col-sm-12">
                                    <span class='text-red comment-note'></span>
                                    {!! Form::textarea("comment", null, ['class'=>$GeneralClasses, 'placeholder'=>'Write
                                    Comment about Transaction', 'rows'=>5, "id"=>"comment"]) !!}
                                </div>
                            </div>

                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div> <!-- /.row -->

        {!! Form::close() !!}
    </section>
</div>
<script type="text/javascript">
function loadPlanDetail() {
    var $basepath = $('meta[name="basepath"]').attr('content')
    var $plan_id = $("#plan_id").val();
    var $period = $("#period").val();
    var $agent_id = $("#agent_id").val();
    var $price = 0;

    $.ajax({
        url: MAIN_PATH + "/admin/subscriber-detail",
        type: "GET",
        dataType: "JSON",
        data: "agent_id=" + $agent_id + "&action={{$action}}&plan_id=" + $plan_id + "&period=" + $period,
        success: function(resp) {
            if (parseInt(resp.finalPrice) < 0) {
                swal("No Refundable", "All prices are no Refundable.", "warning");
            }
            $("#received_payment").val(resp.finalPrice);
            var $plan_price = Math.round(resp.plan_price).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g,
                "$1,");
            var $discount_price = resp.discount_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            var $orignal_price = resp.orignal_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            var $remainingAmount = resp.remainingAmount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g,
                "$1,");
            var $finalPrice = resp.finalPrice.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            if (parseInt($discount_price) == 0) {
                $price = $plan_price;
            } else {
                $price = $discount_price;
            }


            if (resp.notify) {
                $("#plan_price").html("<small>Rs.</small> " + $plan_price +"<small> Per Year</small>");
                $("#discount_price").html("<small>Rs.</small> " + $discount_price);
                $("#orignal_price").html("( " + $price + " x " + resp.period + " ) - " + $remainingAmount);
                $("#remainingAmount").html("<small>Rs.</small> " + $remainingAmount);
                $("#finalPrice").html("<small data-price='" + resp.finalPrice + "'>Rs.</small> " +
                    $finalPrice);
                $("#expire_date").html(new Date(resp.expire_date));
            }
        }
    });
}


$(function() {
 
    loadPlanDetail();
    $("#saveSubscriber").on("click", function() {
        var $SubscribeForm = $("#subscribe");
        if (!$SubscribeForm.validationEngine('validate')) {
            return false;
        }

        swal({
                title: "Are you sure?",
                text: "Please check is every calculation is accurate?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $SubscribeForm[0].submit();
                } else {
                    swal("Cancelled", "Your Settings is safe", "error");
                }
            });

    });




    // $("#subscribe").validationEngine('validate');

    $("#plan_id, #period").change(function() {
        var $id = $(this).val().length;
        if (!$id) {
            return false;
        }
        loadPlanDetail();
    });

    $("#payment_status").change(function() {
        var $id = $(this).val().length;
        var $status = $(this).val();
        var $finalPrice = $("#finalPrice small").attr("data-price");

        if ($status == "pending") {
            $(".expire").hide();
            $("#received_payment").val(0);
            $("#comment").removeClass("validate[required]");
        } else {
            $(".expire").show();
            $("#received_payment").val($finalPrice);
            $("#comment").removeClass("validate[required]");
        }
        if ($id) {
            $("#status").html($(this).val().toUpperCase());
        }
    });

    $("input#received_payment").keyup(function() {
        var totalPrice = $("#finalPrice small").attr("data-price");
        var customPrice = $(this).val();
        if (customPrice != totalPrice || customPrice == 0) {
            $("#comment").addClass("validate[required]");
        } else {
            $("#comment").removeClass("validate[required]");
        }
    });

    // onLoad Check Payment Status
    var $id = $("#payment_status").val().length;
    if ($id) {
        $("#status").html($("#payment_status").val().toUpperCase());
    }

    @if($isAlready)
    $('#addSubscriber').block({
        message: "This agent is aleady subscribed",
        css: {
            border: 'none',
            padding: '10px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .8,
            color: '#fff',
            width: "60%",
            fontSize: "18px"
        }
    });
    @endif
    $("#agent_id").on("change", function() {
        var plan_id = $(this).find(":selected").attr('plan-id');
        var period = $(this).find(":selected").data('period');
        // Plan Section Reset
        $("#plan_id option").each(function() {
            $(this).prop("selected", false)
        });
        $("#plan_id #" + plan_id).prop("selected", true);

        // Period Section Reset
        $("#period option").each(function() {
            $(this).prop("selected", false)
        });

        $("#period #" + period).prop("selected", true)
    });
    $("#period").change(function() {
    var period = $('#period option:selected').val();
      if (period == 1) {
  var price = '2000';
  var date  = "{{date('d M Y', strtotime("+ 1 year"))}}";
  var inpute  = "{{date('Y-m-d h:i:s', strtotime("+ 1 year"))}}";
    }else{
  var price = '3000';
  var date  = "{{date('d M Y', strtotime("+ 2 year"))}}";
  var inpute  = "{{date('Y-m-d h:i:s', strtotime("+ 2 year"))}}";
    }
    // var price = plan * period;
    $('#payment_price').val(price);
    $('#expairy_date_custom').html(date);
    $('#expairy_date_custom_input').val(inpute);
    $('#price_cutome').html('<small>Rs</small> '+price);
});
});
$(document).ready(function() {
    
    $('.select2').select2();
})
</script>
@if($action=="renewal")
<script>
    $(function() {
    $('#period').trigger('change');
    });
</script>
@endif
@endsection