@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Manage Hotels
            <a href="{{ route('admin.add-hotel') }}" class="btn btn-primary pull-right">Add Hotel</a>
        </h1>
    </section>
<section class="content">
               <div class="box" style="margin-bottom:0">
                    <div class="box-body">
                        <form method="get" class="row">
                            <div class="col-md-4">
                                  <input type="text" class="form-control" name="name" placeholder="Hotel Name" value="{{ request()->name }}">
                            </div>
                            <div class="col-md-4">
                                <select name="city" class="form-control">
                                    <option value="">Select City</option>
                                    @foreach($cities as $c)
                                        <option value="{{ $c->id }}" {{ request()->city == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-md-4">
                            <button class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
        </section>
    <section class="content">
               <div class="box">
                    <div class="box-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th width="5%">Image</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>Phone</th>
                    <th>Category</th>
                    <th>Distance</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($hotels as $h)
                <tr>
                    <td>{{ $h->id }}</td>
                       <td>@if(!is_null($h->img))
                                        <img src="{{ url('storage/uploads/hotels/'.$h->img) }}" width="50px">
                                        @else
                                        @endif
                                    </td>
                    <td>{{ $h->name }}</td>
                    <td>{{ $h->cityName->name ?? '' }}</td>
                      <td>{{ $h->phone }}</td>
                    <td>{{ optional($h->category)->name }}</td>
                    <td>{{ optional($h->distance)->name }}</td>
                    <td>{{ $h->status }}</td>

                    <td>
                        <a href="{{ route('admin.edit-hotel', $h->id) }}" class="btn btn-success btn-xs">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $hotels->links() }}
        </div>
        </div>
    </section>
</div>
@endsection
