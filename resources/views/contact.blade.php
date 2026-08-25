@extends('layouts.master')
@section('content')
<section id="content" class="container">
    <div class="row">
        <div class="col-md-3 col-pd">
            <?php if (!$detect->isMobile()): ?>
            <ins class="adsbygoogle" style="display:inline-block;width:280px;height:250px"
                data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            <?php endif ?>
        </div>
        <div class="col-md-9 col-pd">

            <h2>Feedback</h2>

            @if(!empty($content))
            {!! renderHTML($content->content) !!}
            @endif
            <br>
            <!--<form method="post" class="contact" action="{{ url('save-contact') }}">-->
            <!--    {{ csrf_field() }}-->
            <!--    <div class="form-group">-->
            <!--        <label>Name</label>-->
            <!--        <input type="text" name="name" data-validation="required" class="form-control">-->
            <!--    </div>-->
            <!--    <div class="form-group">-->
            <!--        <label>Email</label>-->
            <!--        <input type="text" name="email" class="form-control" data-validation="email">-->
            <!--    </div>-->
            <!--    <div class="form-group">-->
            <!--        <label>Phone</label>-->
            <!--        <input type="text" name="phone" data-validation="required" class="form-control">-->
            <!--    </div>-->
            <!--    <div class="form-group">-->
            <!--        <label>Subject</label>-->
            <!--        <input type="text" name="subject" data-validation="required" class="form-control">-->
            <!--    </div>-->
            <!--    <div class="form-group">-->
            <!--        <label>Message</label>-->
            <!--        <textarea name="message" rows="4" data-validation="required" class="form-control"></textarea>-->
            <!--    </div>-->
            <!--    <div class="form-group">-->
            <!--        {!! NoCaptcha::display() !!}-->
            <!--        <div class="capchtavalidation"></div>-->
            <!--        @if ($errors->has('g-recaptcha-response'))-->
            <!--        <span class="help-block">-->
            <!--            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>-->
            <!--        </span>-->
            <!--        @endif-->
            <!--    </div>-->
            <!--    <div class="form-group">-->
            <!--        <button type="submit" class="btn btn-primary">Send</button>-->
            <!--    </div>-->
            <!--</form>-->

        </div>
        <br>

    </div>
</section>
@endsection