@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Umrah Packages
            <a href="{{ route('admin.add-packages') }}" class="btn btn-primary pull-right">Add Umrah Packages</a>
            <a href="{{ url('admin/add-packages?agent=yes') }}" class="btn btn-primary pull-right" style="margin-right: 10px;">Add Agent Package</a>
        </h1>

    </section>
 <section class="content" style="min-height: 148px;">
         <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
               <!--          <h3>Filters</h3> -->
                        <form method="get" action="{{url('admin/packages')}}">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label> Title</label>
                                <input type="text" name="name" placeholder="Package Title" class="form-control" value="{{request()->has('name')?request()->get('name'):''}}">
                            </div>
                          
                             <div class="col-md-4 form-group">
                                <label>Agents</label>
                                <select name="agent" class="form-control">
                                    <option value=""> Select</option>
                                    @foreach($agents as $c)
                                    <option value="{{$c->id}}" {{request()->has('agent') && request()->get('agent') == $c->id?'selected':''}}>{{$c->business_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                           
                          
                            <div class="col-md-4 form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search" style="margin-right: 10px;"></i> Search</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-hover datatables">
                            <thead>
                                <tr>
                                    <th>Owner</th>
                                    <th>Name</th>
                                    <th>Content1</th>
                                <!--     <th>Content2</th> -->
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($packages as $s)
                                <tr>
                                    <td>
                                        {{ !is_null($s->agent)?$s->agent->business_name:'Agents.com.pk' }}
                                    </td>
                                     <td>
                                        {{ $s->name }}
                                    </td>
                                    <td>
                                        {{ str_limit(strip_tags($s->content1), 100) }}
                                    </td>
                                   <!--  <td>
                                        {!! str_limit($s->content2,100) !!}
                                    </td> -->
                                    <td>
                                        <a href="{{ route('admin.edit-packages', $s->id) }}" title="Edit">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="fa fa-pencil"></i></button></a>
                                        <a href="{{ route('admin.delete-package', $s->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this item?');"
                                            title="delete">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="fa fa-trash"></i></button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')

@endpush