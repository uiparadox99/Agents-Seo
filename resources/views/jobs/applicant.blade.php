@extends('layouts.master')
@section('content')
<section id="content" class="container">
     
            <div style="border: 1px solid;margin:10px 0;padding: 10px;    border-radius: 10px;    border: 2px solid #f58220;">
                   <h2 style="font-weight: bold"> 
                    @if(!is_null($detail->user) && !is_null($detail->user->airline) && !empty($detail->user->airline->img))
                    <img src="{{url('storage/uploads/airline/'.$detail->user->airline->img)}}" height="30">
                     @endif
                    {{ ucfirst($detail->title) }} </h2>

            <div class="row" style="padding: 10px 0">
                <div class="col-md-4">
                    <h6><strong style="font-family:arial;">Post Date : </strong>
                        {{ date('d M Y', strtotime(!empty($detail->post_date) ? $detail->created_at : '')) }} </h6>
                </div>
                <div class="col-md-4">
                    <h6><strong style="font-family:arial;">Last Date to Apply : </strong>
                        {{date('d M Y',strtotime($detail->apply_date))}} </h6>
                </div>
                @if(!empty($detail->offer))
                <div class="col-md-4">
                    <h6 style="font-family:arial;"><strong>Salary Offer : </strong>Rs {{$detail->offer}} </h6>
                </div>
                @endif
                <div class="col-md-4">
                    <h6><strong>Posting City : </strong>{{!is_null($detail->agentCity)?$detail->agentCity->name:''}} </h6>
                </div>
                <div class="col-md-4">
                    <h6><strong>Category : </strong>{{!is_null($detail->jobCategory)?$detail->jobCategory->name:''}}
                    </h6>
                </div>
                <div class="col-md-4">
                    <h6><strong>Experience : </strong>{{!is_null($detail->experience)?$detail->experience:''}}
                    </h6>
                </div>
                <div class="col-md-12">
                    <h6><strong>Job URL :
                        </strong><a href="{{ !is_null($detail->post_url) ? $detail->post_url : '' }}" target="_blank">{{ !is_null($detail->post_url) ? $detail->post_url : '' }}</a>
                    </h6>
                </div>
                <!-- <div class="col-md-5">
                       <a href="https://www.facebook.com/sharer/sharer.php?u={{request()->url()}}" class="btn btn-sm btn-primary" target="_blank " style="    background-color: #2f5b9d;border: none;">
                                    <i class="fab fa-facebook-f" aria-hidden="true"></i> Facebook</a>

                                    <a href="https://twitter.com/share?url={{request()->url()}}r&amp;text={{ ucfirst($detail->title) }}" class="btn btn-sm btn-primary" target="_blank" style="    background-color: #38bff1;border: none;">
                                    <i class="fab fa-twitter" aria-hidden="true"></i> Twitter</a>

                                    <a href="https://wa.me/?text={{ ucfirst($detail->title) }} {{request()->url()}}" class="btn btn-sm btn-primary" target="_blank" style="    background-color: #25D366;border: medium;">
                                    <i class="fab fa-whatsapp" aria-hidden="true" style=""></i> WhatsApp</a>
                    </div> -->
            </div>
            <h6><strong>Requirements</strong></h6>
            <p>{!! $detail->requirement !!}</p>


            </div>
            <h3 class="text-center">Send Request </h3>
            <hr>
            <form method="post" id="contactform" action="{{ url('save-applicant') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="job_id" value="{{$detail->id}}">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Name</label>
                        <input type="text" name="name" data-validation="required" class="form-control alpha"  required="" value="{{auth()->user()->name}}" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" data-validation="email" value="{{auth()->user()->email}}" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Contact Number</label>
                        <input type="text" name="number" data-validation="required" class="form-control numeric" maxlength="15" required="">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Cv Attachment 1</label>
                        <input type="file" name="attachment1" class="form-control" data-validation="required">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Cv Attachment 2</label>
                        <input type="file" name="attachment2" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Cv Attachment 3</label>
                        <input type="file" name="attachment3" class="form-control">
                    </div>
                  <!--   <div class="form-group col-sm-12">
                        <label for="">Remarks</label>
                        <textarea name="remarks" id="" cols="30" rows="4" class="form-control"></textarea>
                    </div> -->
                </div>

                <div class="text-center">

                    <button type="submit" class="btn btn-warning text-white mb-2">Send Job Request</button>
                </div>
            </form>
           <!--  <hr>
            <h3 class="text-center">Job Detail </h3>
            <hr> -->
            <!-- data-toggle="modal" data-target="#applyModal" -->
         
            <?php if (!$detect->isMobile()): ?>
            <div style="width: 100%;">
                <ins class="adsbygoogle" style="display:inline-block;width:100%;height:120px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <?php endif ?>

</section>
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.alphanum/1.0.24/jquery.alphanum.min.js" integrity="sha512-gXwhwYG+MXc3CTdrUQpBDqW+VY4Gpo8dLZsHC5s4X9hitmSZcztF2YPbbeNcFxOiNx6/QeyTCoOw7b+xnm3DwA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
       $(document).ready(function() {
             $('.alpha').alpha();
               $('.numeric').numeric();
       })
</script>
@endpush