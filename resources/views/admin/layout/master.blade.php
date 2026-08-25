<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.includes.head')
</head>

<body class="hold-transition skin-blue sidebar-mini">
    @include('admin.includes.header')
    @include('admin.includes.sidebar')
    @yield('content')

    @include('admin.includes.footer')
    <!-- Bootstrap 3.3.7 -->

    <script src="{{asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Morris.js charts -->
    <script src="{{asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    <script src="{{asset('admin/bower_components/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('admin/bower_components/morris.js/morris.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
    <!-- jvectormap -->
    <script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('admin/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('admin/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('admin/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <script src="{{asset('plugins/toaster/toaster.js')}}"></script>
    <!-- datepicker -->
    <script src="{{asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}">
    </script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- FastClick -->
    <script src="{{asset('admin/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <script src="{{ asset('plugins/wysiwyg/ckeditor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/wysiwyg/adapters/jquery.js') }}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <!-- <script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('admin/dist/js/pages/dashboard.js')}}"></script>
    <script src="{{asset('plugins/formValidator/validator.js')}}"></script>
    <script src="{{asset('plugins/formValidator/maskedinput.js')}}"></script>
    <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{asset('plugins/mulitSelect/js/jquery.multi-select.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.4.0/jquery.quicksearch.min.js"></script>
        <script type="text/javascript" src="{{ asset('plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        
        $('.sidebar-toggle').on('click', function () {
    var sidebar = $('.main-sidebar');
    
    if (sidebar.hasClass('sidebar-open')) {
        // Hide sidebar
        sidebar.css('transform', 'translate(-230px, 0)');
        sidebar.removeClass('sidebar-open');
    } else {
        // Show sidebar
        sidebar.css('transform', 'translate(0px, 0)');
        sidebar.addClass('sidebar-open');
    }
});
            $.validate({
        modules: 'date, security'
    });
        $("textarea.editor").ckeditor();
        $("table.datatables").DataTable({
            "pageLength": 25
        });

        $('#agentbar').typeahead({
        minLength: 0,
        maxLength: 20,
        limit: 20,
        showHintOnFocus: true,
        autoSelect: false,
        source: function(query, result) {
            $.ajax({
                url: "{{url('admin/get-agents')}}",
                data: 'query=' + query,
                dataType: "json",
                type: "GET",
                success: function(data) {
                    return result(data);
                }
            });
        },
         afterSelect: function(args) {
            $('#hiddenAgent').val(args.slug);
        }

       
    });
    });
    </script>
    @include('admin.includes.notifications')
    @stack('script')
</body>

</html>