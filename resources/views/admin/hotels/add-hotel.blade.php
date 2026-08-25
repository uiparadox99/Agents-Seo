@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>{{ isset($hotel) ? 'Edit Hotel' : 'Add Hotel' }}</h1>
    </section>

    <section class="content">
               <div class="box">
                    <div class="box-body">
        <form action="{{ route('admin.save-hotel') }}" method="POST"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $hotel->id ?? '' }}">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-md-offset-2">
                            <label for="">Image</label>
                        </div>
                        @if(isset($hotel)&&!is_null($hotel->img))
                        <div class="col-sm-3">
                            <input type="file" name="img" class="form-control" value="">
                        </div>
                        <div class="col-sm-3">
                            <img src="{{ url('storage/uploads/hotels/'.$hotel->img) }}" width="30%">
                        </div>

                        @else
                        <div class="col-sm-6">
                            <input type="file" name="img" class="form-control" value="">
                        </div>
                        @endif
                    </div>
                </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $hotel->name ?? '' }}" class="form-control" required>
                </div>

                 <div class="col-md-6 form-group">
                    <label>City</label>
                    <select name="city" class="form-control" required>
                        <option value="">Select City</option>
                        <option value="26" {{ isset($hotel) && $hotel->city == 26 ? 'selected' : '' }}>Makkah</option>
                        <option value="5" {{ isset($hotel) && $hotel->city == 5 ? 'selected' : '' }}>Madina</option>
                    </select>
                </div>

             

                <div class="col-md-6 form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $hotel->phone ?? '' }}" class="form-control">
                </div>

                <div class="col-md-6 form-group">
                    <label>Hotel Category</label>
                    <select name="hotel_category" class="form-control">
                        <option value="">Select</option>
                        @foreach($categories as $c)
                        <option value="{{ $c->id }}" 
                            {{ isset($hotel) && $hotel->hotel_category == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label>Distance</label>
                    <select name="distance_id" class="form-control">
                        <option value="">Select</option>
                        @foreach($distances as $d)
                        <option value="{{ $d->id }}"
                            {{ isset($hotel) && $hotel->distance_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">Select</option>
                        <option value="Enable" {{ isset($hotel) && $hotel->status == 'Enable' ? 'selected' : '' }}>Enable</option>
                        <option value="Disabel" {{ isset($hotel) && $hotel->status == 'Disabel' ? 'selected' : '' }}>Disable</option>
                    </select>
                </div>
                   <div class="col-md-6 form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control">{{ $hotel->address ?? '' }}</textarea>
                </div>
                <div class="col-md-6 form-group">
                    <label>Facilities</label>
                    <textarea name="hotel_facilities" class="form-control">{{ $hotel->hotel_facilities ?? '' }}</textarea>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
               </div>
            </div>
    </section>
</div>
@endsection
