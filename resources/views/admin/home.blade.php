@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <?php if (auth()->guard('admin')->user()->type == 'admin'): ?>
        <div class="row">
       <!--      <div class="col-lg-3 col-xs-6">
       
           <div class="small-box bg-aqua">
               <div class="inner">
                   <h3>{{$total_visa}}</h3>
       
                   <p>Total Visa</p>
               </div>
               <div class="icon">
                   <i class="ion ion-bag"></i>
               </div>
               <a href="{{url('admin/manage-visa')}}" class="small-box-footer">More info <i
                       class="fa fa-arrow-circle-right"></i></a>
           </div>
       </div> -->
            <!--<div class="col-lg-2 col-xs-6">-->
                <!-- small box -->
            <!--    <div class="small-box bg-aqua">-->
            <!--        <div class="inner">-->
            <!--            <h3>{{$contact}}</h3>-->

            <!--            <p>Total contact Request</p>-->
            <!--        </div>-->
            <!--        <div class="icon">-->
            <!--            <i class="fa fa-envelope"></i>-->
            <!--        </div>-->
            <!--        <a href="{{url('admin/contact')}}" class="small-box-footer">More info <i-->
            <!--                class="fa fa-arrow-circle-right"></i></a>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$airlines}}</h3>

                        <p>Total Airlines</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-plane"></i>
                    </div>
                    <a href="{{url('admin/airline')}}" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$packages}}</h3>

                        <p>Total Umrah Packages</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-gift"></i>
                    </div>
                    <a href="{{url('admin/packages')}}" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

          <div class="col-lg-2 col-xs-6">
              <div class="small-box bg-aqua">
                  <div class="inner">
                      <h3>{{$embassies}}</h3>
          
                      <p>Total Embassies</p>
                  </div>
                  <div class="icon">
                      <i class="fa fa-plane"></i>
                  </div>
                  <a href="{{url('admin/embassy')}}" class="small-box-footer">More info <i
                          class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div> 
            <!--<div class="col-lg-2 col-xs-6">-->
            <!--    <div class="small-box bg-aqua">-->
            <!--        <div class="inner">-->
            <!--            <h3>{{$newsletter}}</h3>-->

            <!--            <p>Total Newsletter</p>-->
            <!--        </div>-->
            <!--        <div class="icon">-->
            <!--            <i class="fa fa-plane"></i>-->
            <!--        </div>-->
            <!--        <a href="{{url('admin/newsletter')}}" class="small-box-footer">More info <i-->
            <!--                class="fa fa-arrow-circle-right"></i></a>-->
            <!--    </div>-->
            <!--</div>-->
             <div class="col-lg-2 col-xs-6"> 
              <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{$agent}}</h3>

                        <p>Total Agents</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <a href="{{url('admin/agents')}}" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
               <div class="col-lg-2 col-xs-6"> 
              <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$verified_agent}}</h3>

                        <p>Verified Agents</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <a href="{{url('admin/agents?agent_verified=1')}}" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-xs-6"> 
              <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$non_verified_agent}}</h3>

                        <p>No Verified Agents</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <a href="{{url('admin/agents?agent_verified=0')}}" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <div class="row">
                        @foreach($agent_types as $key => $at)
                    
                            <div class="col-md-2 pr-1 pl-1 text-center" style="padding-top: 20px;">
                                <h3 class="text-center">{{$at->agents()->count()}}</h3>
                                <h4 class="text-center">{{$at->name}} Agents</h4>
                            
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
              <div class="col-lg-6 col-xs-6"> 
                <div class="small-box bg-blue">
                    <div class="inner">
                        <div class="dashboard_counts" style="">
                            <div>
                                <h4 style="margin-bottom:15px;font-weight:bolder">Sasti Tickets</h4>
                                <h4>Daily: {{$today_sasti_ticket_visitors}}</h4>
                                @foreach($daily_chart['sasti_tickets'] as $key => $co)
                                   <h4>{{date('d M Y',strtotime($key))}}: {{$co}}</h4>
                                  @endforeach
                                <h4>Week: {{$week_sasti_ticket_visitors}}</h4>
                                <h4>Total: {{$sasti_ticket_visitors}}</h4>
                            </div>
                            <div>
                                <h4 style="margin-bottom:15px;font-weight:bolder">Umrah Tickets</h4>
                                <h4>Daily: {{$today_umrah_tickets_visitors}}</h4>
                                 @foreach($daily_chart['umrah_tickets'] as $key => $co)
                                   <h4>{{date('d M Y',strtotime($key))}}: {{$co}}</h4>
                                  @endforeach
                                <h4>Week: {{$week_umrah_tickets_visitors}}</h4>
                                <h4>Total: {{$umrah_tickets_visitors}}</h4>
                            </div>
                             <div>
                                 <h4 style="margin-bottom:15px;font-weight:bolder">Agent Jobs</h4>
                                 <h4>Daily: {{$today_agent_job_visitors}}</h4>
                                  @foreach($daily_chart['agent_job'] as $key => $co)
                                   <h4>{{date('d M Y',strtotime($key))}}: {{$co}}</h4>
                                  @endforeach
                                 <h4>Week: {{$week_agent_job_visitors}}</h4>
                                 <h4>Total: {{$agent_job_visitors}}</h4>
                            </div>
                            <div>
                                <h4 style="margin-bottom:15px;font-weight:bolder">Airline Jobs</h4>
                                <h4>Daily: {{$today_job_visitors}}</h4>
                                 @foreach($daily_chart['job'] as $key => $co)
                                   <h4>{{date('d M Y',strtotime($key))}}: {{$co}}</h4>
                                  @endforeach
                                <h4>Week: {{$week_job_visitors}}</h4>
                                <h4>Total: {{$job_visitors}}</h4>
                            </div>
                             <div>
                                <h4 style="margin-bottom:15px;font-weight:bolder">Foreign Jobs</h4>
                                <h4>Daily: {{$today_foreign_job_visitors}}</h4>
                                 @foreach($daily_chart['foreign_job'] as $key => $co)
                                   <h4>{{date('d M Y',strtotime($key))}}: {{$co}}</h4>
                                  @endforeach
                                <h4>Week: {{$week_foreign_job_visitors}}</h4>
                                <h4>Total: {{$foreign_job_visitors}}</h4>
                            </div>
                             <div>
                                <h4 style="margin-bottom:15px;font-weight:bolder">Total</h4>
                                <h4>Daily: {{$today_visitors}}</h4>
                                <h4>Week: {{$week_visitors}}</h4>
                                <h4>Total: {{$visitors}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Agents Count By Cities:  <a href="#demo" class="btn btn-primary btn-lg" data-toggle="collapse">Show Cities</a></h4>
         <div id="demo" class="collapse">
        <div class="row">
            @foreach($agent_cities as $c)
        <div class="col-lg-2 col-xs-2 pr-0"> 
        <p> <a href="{{url('admin/agents?city='.$c->id)}}" style="color:black;display:block;width:100%">{{$c->name}} <span style="float:right">{{$c->agents_count}}</span></a></p>
                  
            </div>
            @endforeach
        </div>
        </div>
<!--        <form action="{{url('import-workers')}}" method="POST" enctype="multipart/form-data">-->
<!--    @csrf-->
<!--    <input type="file" name="file" required>-->
<!--    <button type="submit">Import Sheet</button>-->
<!--</form>-->
        <!-- /.row -->

        <?php endif ?>
    </section>
    <!-- /.content -->
</div>

@endsection