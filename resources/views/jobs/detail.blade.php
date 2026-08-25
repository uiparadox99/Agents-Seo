@extends('layouts.master')
@section('content')
    <section id="content" class="container">
        <div class="row">
            <!-- <div class="col-md-3 col-pd">
                    <?php if (!$detect->isMobile()): ?>
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:280px;height:220px"
                         data-ad-client="ca-pub-9682339330195266"
                         data-ad-slot="3145814347"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                     <?php endif ?>

                 
                </div> -->
            <div class="col-md-12">

                <!-- data-toggle="modal" data-target="#applyModal" -->
                <a class="text-dark" href="{{ url('agent/' . $detail->agent->slug) }}">
                    <h2 class="job-title text-capitalize">{{ ucfirst($detail->title) }} @if (!$detect->isMobile())
                            <a href="{{ url('applicant/' . $detail->slug) }}" class="btn btn-success btn-sm"
                                style="float:right">Apply Now</a>
                        @endif
                    </h2>
                </a>

                <div class="row" style="padding: 10px 0">
                    <div class="col-md-4">
                        <h6><strong style="font-family:arial;">Post Date : </strong>
                            {{ date('d M Y', strtotime(!empty($detail->post_date) ? $detail->created_at : '')) }} </h6>
                    </div>
                    <div class="col-md-4">
                        <h6><strong style="font-family:arial;">Last Date of Apply : </strong>
                            {{ date('d M Y', strtotime($detail->apply_date)) }} </h6>
                    </div>
                    
                    <div class="col-md-4">
                        <h6 style="font-family:arial;"><strong>Salary Offer : </strong>Rs {{ $detail->offer }} </h6>
                    </div>
                    <div class="col-md-4">
                        <h6><strong>Posting City : </strong>{{ !is_null($detail->agentCity) ? $detail->agentCity->name : '' }} </h6>
                    </div>
                    <div class="col-md-4">
                        <h6><strong>Category : </strong>{{ !is_null($detail->jobCategory) ? $detail->jobCategory->name : '' }}
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <h6><strong>Experience :
                            </strong>{{ !is_null($detail->jobExperience) ? $detail->jobExperience->name : '' }}
                        </h6>
                    </div>
                    <div class="col-md-12">
                        <h6><strong>Job URL :
                            </strong><a href="{{ !is_null($detail->job_url) ? $detail->job_url : '' }}" target="_blank">{{ !is_null($detail->job_url) ? $detail->job_url : '' }}</a>
                        </h6>
                    </div>
                    <!-- <div class="col-md-5">
                           <a href="https://www.facebook.com/sharer/sharer.php?u={{ request()->url() }}" class="btn btn-sm btn-primary" target="_blank " style="    background-color: #2f5b9d;border: none;">
                                        <i class="fab fa-facebook-f" aria-hidden="true"></i> Facebook</a>

                                        <a href="https://twitter.com/share?url={{ request()->url() }}r&amp;text={{ ucfirst($detail->title) }}" class="btn btn-sm btn-primary" target="_blank" style="    background-color: #38bff1;border: none;">
                                        <i class="fab fa-twitter" aria-hidden="true"></i> Twitter</a>

                                        <a href="https://wa.me/?text={{ ucfirst($detail->title) }} {{ request()->url() }}" class="btn btn-sm btn-primary" target="_blank" style="    background-color: #25D366;border: medium;">
                                        <i class="fab fa-whatsapp" aria-hidden="true" style=""></i> WhatsApp</a>
                        </div> -->
                </div>
                <h6><strong>Requirements</strong></h6>
                <p>{!! $detail->requirement !!}</p>
                @if ($detect->isMobile())
                    <div class="text-center">
                        <a href="{{ url('applicant/' . $detail->slug) }}" class="btn btn-success btn-sm"
                            style="margin-bottom:8px;">Apply Now</a>
                    </div>
                @endif
         
            </div>
        </div>
    </section>
    <div id="applyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Apply Now </h4>
                    <button type="button" class=" model-close-button pull-right btn btn-warning" data-dismiss="modal"><i
                            class="fa fa-times	text-white"></i></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="contactform" action="{{ url('save-applicant') }}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="job_id" value="{{ $detail->id }}">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Name</label>
                                <input type="text" name="name" data-validation="required" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" data-validation="email">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Contact Number</label>
                                <input type="text" name="number" data-validation="required" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Cv Attachment</label>
                                <input type="file" name="attachment" class="form-control">
                            </div>



                        </div>

                        <div class="text-center">

                            <button type="submit" class="btn btn-warning text-white">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
