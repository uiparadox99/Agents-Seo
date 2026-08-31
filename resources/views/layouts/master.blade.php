<!DOCTYPE html>
<html lang="en-PK">

<head>
    @include('includes.meta')
    @include('includes.head')
</head>

<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v18.0"></script>

    <div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="feedbackModalLabel">Feedback</h4>
                    <button type="button" class="model-close-button pull-right btn btn-warning" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times text-white"></i>
                    </button>
                </div>
                <form method="post" id="contactform" action="{{ url('save-contact') }}">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="feedback-name">Name</label>
                                <input type="text" id="feedback-name" name="name" data-validation="required" class="form-control" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="feedback-email">Email</label>
                                <input type="email" id="feedback-email" name="email" class="form-control" data-validation="email" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="feedback-phone">Phone</label>
                                <input type="text" id="feedback-phone" name="phone" data-validation="required" class="form-control" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="feedback-subject">Subject</label>
                                <input type="text" id="feedback-subject" name="subject" data-validation="required" class="form-control" required>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="feedback-message">Message</label>
                                <textarea id="feedback-message" name="message" rows="4" data-validation="required" class="form-control" required></textarea>
                            </div>
                            @if(config('captcha.sitekey'))
                            <div class="form-group col-md-6 col-md-offset-3">
                                {!! NoCaptcha::display() !!}
                                <div class="capchtavalidation"></div>
                                @if (isset($errors) && $errors->has('g-recaptcha-response'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-warning text-white font-weight-bold">Send Feedback</button>
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

    <!-- Vendor & Core Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('plugins/formValidator/validator.js') }}"></script>
    <script src="{{ asset('plugins/toaster/toaster.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/wysiwyg/ckeditor.js') }}"></script>
    <script src="{{ asset('plugins/wysiwyg/adapters/jquery.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @if(config('captcha.sitekey'))
    {!! NoCaptcha::renderJs() !!}
    @endif

    <script>
    $(document).ready(function() {
        if ($.validate) {
            $.validate({
                modules: 'date, security'
            });
        }

        if ($("textarea.editor").length && $.fn.ckeditor) {
            $("textarea.editor").ckeditor();
        }

        $("#contactform").on('submit', function(event) {
            if ($("#g-recaptcha-response").length) {
                var recaptcha = $("#g-recaptcha-response").val();
                if (!recaptcha) {
                    event.preventDefault();
                    $('.capchtavalidation').html('<p style="color:red;font-weight:600;">Captcha Required</p>');
                }
            }
        });

        if ($('.select2').length) {
            $('.select2').select2();
        }

        $('#expanduserSidebar').on('click', function() {
            $('.sidebar').toggle();
        });

        if ($('.customer-logos').length) {
            $('.customer-logos').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2500,
                arrows: true,
                dots: false,
                pauseOnHover: false,
                responsive: [
                    { breakpoint: 768, settings: { slidesToShow: 4 } },
                    { breakpoint: 520, settings: { slidesToShow: 4 } }
                ]
            });
        }

        if ($('.flayer-logos').length) {
            $('.flayer-logos').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2500,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [
                    { breakpoint: 768, settings: { slidesToShow: 2 } },
                    { breakpoint: 520, settings: { slidesToShow: 2 } }
                ]
            });
        }

        $(document).on('click', '#submitSearch', function() {
            var input = $('#country').val();
            if (input !== '') {
                $('#searchForm').submit();
            }
        });

        $(document).on('click', '#submitAgentSearch', function() {
            var input = $('#agentbar').val();
            if (input !== '') {
                $('#AgentSearchForm').submit();
            }
        });

        if ($('.timeMask').length) {
            $('.timeMask').mask('99:99');
        }

        if ($('#agentbar').length) {
            $('#agentbar').typeahead({
                minLength: 0,
                showHintOnFocus: true,
                autoSelect: false,
                source: function(query, result) {
                    $.ajax({
                        url: "{{ url('get-agents') }}",
                        data: 'query=' + encodeURIComponent(query),
                        dataType: "json",
                        type: "GET",
                        success: function(data) {
                            return result(data);
                        }
                    });
                },
                afterSelect: function(args) {
                    if (args && args.slug) {
                        window.location.href = args.slug;
                    }
                }
            });
        }

        $('.city, .type').on('change', function() {
            $('#filtersForm').submit();
        });
    });

    function openNav() {
        var nav = document.getElementById("mySidenav");
        if (nav) nav.style.width = "250px";
    }

    function closeNav() {
        var nav = document.getElementById("mySidenav");
        if (nav) nav.style.width = "0";
    }

    function copy() { 
        var copyElem = document.getElementById("copycontent");
        if (!copyElem) return;
        var copyText = copyElem.getAttribute("href");
        const el = document.createElement('textarea');
        el.value = copyText;
        el.setAttribute('readonly', '');
        el.style.position = 'absolute';
        el.style.left = '-9999px';
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);    

        if (typeof toastr !== 'undefined') {
            toastr["success"]('Link Copied');
        }
    }
    </script>

    <script type="text/javascript">
    $(function() {
        if ($('.datepicker').length) {
            $('.datepicker').datepicker({
                format: "dd-mm-yyyy",
                startDate: new Date
            });
        }
        if ($('.unidatepicker').length) {
            $('.unidatepicker').datepicker({
                format: "dd-mm-yyyy"
            });
        }
        if ($('.today-date').length) {
            $('.today-date').datepicker({
                format: "d-M-yyyy",
                autoclose: true
            });
        }
        if ($('.ticket-date').length) {
            $('.ticket-date').datepicker({
                format: "d-M-yyyy",
                endDate: new Date(),
                autoclose: true
            });
        }

        var tabName = window.location.href;
        var id = $("#accordion a[data-url='" + tabName + "']").attr("href");
        if (id) {
            $(id).collapse('show');
        }
        $(document).on('click', '.main_title', function() {
            var url = $(this).data("url");
            if (url) window.location.href = url;
        });
    });
    </script>

    @include('admin.includes.notifications')

    @stack('script')
</body>

</html>