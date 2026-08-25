<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.includes.head')
</head>

<body class="skin-blue layout-top-nav">
	<div class="wrapper">
		@include('admin.includes.header')

		@yield('content')

		@include('admin.includes.footer')
	</div>
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
<script src="{{asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('admin/bower_components/fastclick/lib/fastclick.js')}}"></script>
<script src="{{ asset('admin/plugins/wysiwyg/ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/plugins/wysiwyg/adapters/jquery.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('admin/dist/js/pages/dashboard.js')}}"></script>
<script src="{{asset('plugins/formValidator/validator.js')}}"></script>
<script src="{{asset('plugins/formValidator/maskedinput.js')}}"></script>
<script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.alphanum/1.0.24/jquery.alphanum.min.js"></script>
<script>
    $(document).ready(function(){
        $('.numeric').numeric();
        $('.alpha').alpha();
       /* $("textarea.editor").ckeditor();*/
        $("table.datatables").DataTable();
        $("table.datatable").DataTable({
            "ordering": false
        });
         $("table.income-table").DataTable({
            "ordering": false,
            "pageLength": 50
        });


        $(".select2").select2();
        $.validate();
        $('input.datepicker').datepicker({
            format: "d-M-yyyy",
            autoclose: true,
        });
         $('.Searchdatepicker').datepicker({
            format: "d-M-yyyy",
             endDate: new Date(),
            autoclose: true,
        });


        $('input').attr('autocomplete','off');
        tinymce.init({
            selector: 'textarea.editor',
          height: 300 - 99,
          toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image',
          content_css: [
          '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
          '//www.tinymce.com/css/codepen.min.css'    
          ]
      })

    });
</script>
@if(isset($tickets) || request()->has('report_date'))
<script>
    $(document).ready(function(){
      
    

        $('.today-date').datepicker({
            format: "d-M-yyyy",
            "autoclose": true
        });

          $('.ticket-date').datepicker({
            format: "d-M-yyyy",
            endDate: new Date(),
            "autoclose": true
        });

        

    });
</script>
@else
<script>
    $(document).ready(function(){
      
    

        $('.today-date').datepicker({
            format: "d-M-yyyy",
            "autoclose": true
        })
      /*  .datepicker("setDate",'now');*/

          $('.ticket-date').datepicker({
            format: "d-M-yyyy",
            endDate: new Date(),
            "autoclose": true
        });
/*.datepicker("setDate",'now')
*/        

    });
</script>
@endif
<script src="{{asset('js/custom.js')}}"></script>
@include('admin.includes.notifications')
 @stack('script')
</body>
</html>
