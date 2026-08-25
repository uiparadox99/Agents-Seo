@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
    <div class="container">
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Manage Parties</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('add-party') }}" class="btn btn-danger  btn-block">Add Party</a>
                    </div>
                </div> 
                {{-- PartyDatatables --}}
                <div class="box-body">
                    <form class="form-validation" method="GET">

                        <div class="filters" style="margin-top: 10px">
                           <div class="row">
                            <div class="col-md-2 form-group">
                                <label>Party name</label>
                                <input type="text" name="party_name" class="form-control" value="{{app('request')->input('party_name')}}" placeholder="Party Name">
                            </div>
                            <div class="col-md-2 form-group">
                                <label>Party Number</label>
                                <input type="text" name="party_number" class="form-control" value="{{app('request')->input('party_number')}}" placeholder="Party Number">
                            </div>
                              <div class="col-md-2 form-group">
                                 <label>Sector</label>
                                 <select name="sector" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($sectors as $p)
                                    <option value="{{ $p->name }}" {{ app('request')->input('sector') == $p->name?'selected':'' }}>
                                    {{ $p->name }}
                                    </option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-md-2 col-xs-6">
                                 <label  >&nbsp;</label><br>
                                 <input type="submit" class="btn btn-success btn-block" value="Search">
                              </div>
                              <div class="col-md-2 col-xs-6">
                                 <label  >&nbsp;</label><br>
                                 <a href="{{ route('manage-parties') }}" class="btn btn-primary btn-block">All</a>
                              </div>
                             
                           </div>
                        </div>
                     </form>
                     <hr>
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th width="4%">Sr No.</th>
                            <th width="25%">Party</th>
                            <th>Account No.</th>
                            <!--<th>Current Amount</th>-->
                            <th width="7%">Phone</th>
                            <th width="7%">Phone 2 </th>
                            <th width="7%">Phone 3</th>
                            <th width="8%">Staff</th>
                            <th width="5%">Sector</th>
                            <th width="8%">Second Sector </th>
                            <!--<th width="10%">Cash Management</th>-->
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($parties as $p)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td> <a href="{{ url('admin/detail-party').'/'.$p->id }}" style="color: unset;">{{ $p->name }}</a></td>
                                <td>{{ $p->code }}</td>
                                <!--<td>{{ $p->current_balance }}</td>-->
                                <td>{{ $p->phone }}</td>
                                <td>{{ $p->phone_2 }}</td>
                                <td>{{ $p->phone_3 }}</td>
                                <td>{{ !is_null($p->admin)?$p->admin->name:'' }}</td>
                                <td>{!! !empty($p->sector)?$p->sector:'<i class="fa fa-times text-danger"></i>' !!}</td>
                                <td>{{ $p->sector_two }}</td>
                                <!--<td>-->
                                <!--    <a href="{{ url('admin/party-transactions').'/'.$p->id }}" class="btn btn-success btn-sm">All Transactions</a>-->
                                <!--</td>-->
                                <td>
                                    <!--<a href="{{ url('admin/detail-party').'/'.$p->id }}" class="btn btn-primary btn-sm"><i class="fa fa-file"></i></a> -->
                                    <!--<a href="{{url('manage-tasks?date_start=&date_end=&parties_id='.$p->id.'&inquiry_num=&admins_id=all&statuses_id=all&task_types_id=&position_type=')}}" class="btn btn-warning btn-sm">Tasks</a>&nbsp;-->
                                    <a href="{{ url('edit-party').'/'.$p->id }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $parties->appends(request()->except(['page','_token']))->links() !!}
                </div>

            </div>
        </section>
    </div>

@endsection

@push('script')
    <script type="text/javascript">
        $(function(){
            $(".PartyDatatables").DataTable({
                "pageLength": 50
            });
        })
    </script>
@endpush
