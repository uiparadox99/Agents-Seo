@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Images
            <a href="{{ route('admin.add-image') }}" class="btn btn-primary pull-right">Add Image</a>
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-hover datatables">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Url</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($images as $s)
                                <tr>
                                    <td>@if(!empty($s->image))
                                        <img src="{{ url('storage/uploads/images/'.$s->image) }}" width="100px">
                                        @else
                                        <img src="//placehold.it/150x150">
                                        @endif
                                    </td>
                                    <?php
                                $url = '<img src="'.url('storage/uploads/images/'.$s->image).'" width="100%" alt="'.$s->image_alt.'">';

                                 ?>
                                    <td>
                                        {{ $url }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-image', $s->id) }}" title="Edit">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="fa fa-pencil"></i></button></a>
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