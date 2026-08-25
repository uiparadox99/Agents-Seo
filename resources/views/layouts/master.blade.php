<!DOCTYPE html>
<html lang="en-PK">

<head>
    @include('includes.meta')

    @include('includes.head')
</head>

<body>
    <div id="fb-root"></div>
    <script async defer
        src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&autoLogAppEvents=1&version=v3.2&appId=2040575169371835">
    </script>
    <!--<?php if (!$detect->isMobile()): ?>-->
    <!--<button type="button" class="btn default-btn btn-lg floting-btn" data-toggle="modal"-->
    <!--    data-target="#myModal">Feedback</button>-->
    <!--<?php endif ?>-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Feedback </h4>
                    <button type="button" class=" model-close-button pull-right btn btn-warning" data-dismiss="modal"><i
                            class="fa fa-times	text-white"></i></button>
                </div>
                <form method="post" id="contactform" action="{{ url('save-contact') }}">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Name</label>
                                <input type="text" name="name" data-validation="required" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" data-validation="email">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Phone</label>
                                <input type="text" name="phone" data-validation="required" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Subject</label>
                                <input type="text" name="subject" data-validation="required" class="form-control">
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Message</label>
                                <textarea name="message" rows="4" data-validation="required" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-6 col-md-offset-3">
                                {!! NoCaptcha::display() !!}
                                <div class="capchtavalidation"></div>
                                @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="text-center">

                            <button type="submit" class="btn btn-warning text-white">Send</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
<div class="main-cutome-wrapper">
    

    @include('includes.header')

    @yield('content')
</div>
    @include('includes.footer')
    <script src="{{asset('js/jquery.min.js')}}"></script>

    <!-- 
	Popper JS
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->

    <!-- Latest compiled JavaScript -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{asset('plugins/formValidator/validator.js')}}"></script>
    <script src="{{asset('plugins/toaster/toaster.js')}}"></script>
    <!-- <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script> -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{asset('js/slick.min.js')}}"></script>
    <script src="{{asset('js/datepicker.min.js')}}"></script>
    <script src="{{ asset('plugins/wysiwyg/ckeditor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/wysiwyg/adapters/jquery.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
    
    {!! NoCaptcha::renderJs() !!}
    <script>
    $.validate({
        modules: 'date, security'
    });
    $("textarea.editor").ckeditor();
    $("#contactform").submit(function(event) {

        var recaptcha = $("#g-recaptcha-response").val();
        if (recaptcha === "") {
            event.preventDefault();
            $('.capchtavalidation').html('<p style="color:red;">Captcha Required</p>');
        }
    });

    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
         $( document ).ready(function() {
             $('.select2').select2();
    $('#expanduserSidebar').click(function() {

     $('.sidebar').toggle();
   });
  });
    $(document).ready(function() {
        $('.customer-logos').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2500,
            arrows: true,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 4
                }
            }]
        });
    });
    $(document).ready(function() {
        $('.flayer-logos').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2500,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 2
                }
            }]
        });
    });
    $(document).on('click', '#submitSearch', function() {
        var input = $('#country').val();
        if (input != '') {

            $('#searchForm').submit();
        }
    });
     $(document).on('click', '#submitAgentSearch', function() {
        var input = $('#agentbar').val();
        if (input != '') {

            $('#AgentSearchForm').submit();
        }
    });
    </script>

    <script type="text/javascript">
    $(function() {
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            startDate: new Date
        });
        $('.unidatepicker').datepicker({
            format: "dd-mm-yyyy",
        });
        var tabName = window.location.href;

        var id = $("#accordion a[data-url='" + tabName + "']").attr("href");
        $(id).collapse('show');
        $(document).on('click', '.main_title', function() {
            var $this = $(this);
            var url = $this.data("url");
            window.location.href = url;
        });
    })
    $(document).ready(function() {

    if($('.timeMask').length){
        $('.timeMask').mask('99:99');
    }
    $('#agentbar').typeahead({
        minLength: 0,
        showHintOnFocus: true,
        autoSelect: false,
        source: function(query, result) {
            $.ajax({
                url: "{{url('get-agents')}}",
                data: 'query=' + query,
                dataType: "json",
                type: "GET",
                success: function(data) {
                    return result(data);
                }
            });
        },

        afterSelect: function(args) {
            window.location.href = args.slug;
        }
    });
    $('.city').on('change', function() {
        $('#filtersForm').submit();
    });
    $('.type').on('change', function() {
        $('#filtersForm').submit();
    });

});

    function copy() { 
       var copyText = document.getElementById("copycontent").getAttribute("href");
       const el = document.createElement('textarea');
       el.value = copyText;
       el.setAttribute('readonly', '');
       el.style.position = 'absolute';
       el.style.left = '-9999px';
       document.body.appendChild(el);
       el.select();
       document.execCommand('copy');
       document.body.removeChild(el);    

        toastr["success"]('Link Copied');
    }

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
    @include('admin.includes.notifications')

    @stack('script')
    @if (!$detect->isMobile())
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c431122b90683c2"></script>
    @endif


</body>

</html>