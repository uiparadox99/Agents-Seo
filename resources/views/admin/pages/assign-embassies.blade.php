@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Assign Embassies
        </h1>

    </section>
    @if(!isset(request()->employee) && empty(request()->employee))
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <form action="{{url('admin/assign-embassy')}}" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Select Employee</label>


                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" name="employee">
                                        <option>Select</option>
                                        @foreach($employees as $em)
                                        <option value="{{$em->id}}">{{$em->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Select</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @else
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <form action="{{url('admin/assign')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="employee" value="{{$selectedEmployee->id}}">

                            <h3 class="text-center">Assign Countries to : <b>{{$selectedEmployee->name}}</b></h3>
                            <hr>

                            <select id='custom-headers' class="searchable" name="country[]" multiple='multiple'>
                                @foreach($countries as $c)
                                @php
                                $selected = '';
                                if(in_array($c->id,$assigned)){

                                $selected = 'selected';
                                }
                                @endphp
                                <option value='{{$c->id}}' {{$selected}}>{{$c->country}} </option>
                                @endforeach
                            </select>
                            <br>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</div>

@endsection
@push('script')
<script type="text/javascript">
$('.searchable').multiSelect({
    selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search For Country'>",
    selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search For Country'>",
    afterInit: function(ms) {
        var that = this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#' + that.$container.attr('id') +
            ' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            .on('keydown', function(e) {
                if (e.which === 40) {
                    that.$selectableUl.focus();
                    return false;
                }
            });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function(e) {
                if (e.which == 40) {
                    that.$selectionUl.focus();
                    return false;
                }
            });
    },
    afterSelect: function() {
        this.qs1.cache();
        this.qs2.cache();
    },
    afterDeselect: function() {
        this.qs1.cache();
        this.qs2.cache();
    }
});
</script>
@endpush