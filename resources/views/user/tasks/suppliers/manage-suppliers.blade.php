@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
    <div class="container">
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Manage Suppliers</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('add-supplier') }}" class="btn btn-danger btn-block">Add Supplier</a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered datatables">
                        <thead>
                        <tr>
                            <th width="5%">Sr No.</th>
                            <th>Supplier</th>
                            <th>Account No.</th>
                            <!--<th>Current Balance</th>-->
                            <!--<th width="30%">Cash Management</th>-->
                            <th width="5%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($suppliers as $s)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $s->name }}</td>
                                <td>{{ $s->code }}</td>
                                <!--<td>{{ $s->current_balance }}</td>-->
                                <!--<td>-->
                                <!--    <a href="{{ url('admin/supplier-transactions').'/'.$s->id }}" class="btn btn-success btn-sm">All Transactions</a>-->
                                <!--</td>-->
                                <td>
                                    <a href="{{ url('edit-supplier').'/'.$s->id }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </section>
    </div>

@endsection

@push('script')
    <script type="text/javascript">
        $(function(){
            function genDataTable(type = null) {
                i = 1;
                $('#taskDataTable').DataTable({
                    serverSide: true,
                    ajax: {
                        url: "{{ route('manage-suppliers') }}"
                    },
                    columns: [
                        { name: "id", render: function(data, type, row, meta){
                                return i++;
                            }},
                        { name: 'name' },
                        { name: "id", render: function(data, type, row, meta){
                                var $html = `<a href="{{ url('admin/supplier-transactions') }}/`+data+`" class="btn btn-success btn-sm">All Transactions</a>
				<a href="{{ url('edit-supplier') }}" class="btn btn-primary btn-sm">Add Amount</a>`;
                                return $html;
                            } },
                        { name: "id", render: function(data, type, row, meta){
                                var $html = `<a href="{{ url('admin/edit-supplier') }}/`+data+`" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>`;
                                return $html;
                            } }
                    ],

                });
            }
            genDataTable();
        })
    </script>
@endpush
