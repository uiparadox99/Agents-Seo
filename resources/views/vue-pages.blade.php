<!doctype html>
<html lang="en-US">

<head>
    @include("studio-includes.header")

</head>

<body class="landing-page">
    <div id="app">
        <transition name="fade" mode="out-in">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>
    </div>
    <script src="{{asset('studio/assets/js/jquery.min.js')}}"></script>

    <script src="{{asset('studio/assets/js/propper.min.js')}}"></script>
    <script src="{{asset('studio/assets/js/bootstrap.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if(request()->path() == 'studio/upload-template')
    <script src="{{ asset('js/up-app.js') }}"></script>
    @else
    <script src="{{ asset('js/app.js') }}"></script>
    @endif
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('studio/assets/js/jquery.ui.rotatable.js')}}"></script>
    <script src="https://unpkg.com/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.panel-display').remove()
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
</body>

</html>
{{-- <script  src="{{url('public/assets/js/custom.js')}}"></script> --}}
{{-- <script src="https://unpkg.com/vue-recaptcha@latest/dist/vue-recaptcha.min.js"></script> --}}

{{-- <script src="{{ url('assets/js/laapp.min.js')}}"></script> --}}