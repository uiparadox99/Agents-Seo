@extends('layouts.master')
@section('content')
<section class="advertise-header">
    <h1 class="heading">Advertise</h1>
</section>
<section id="advertise-body " class="mt-3 mb-3" s>
    <div class="container">
        <div class="row">
            <div class="col-md-9">

                <div class="advertise-maps ">
                    <div class="heading">
                        Side Bars of Every Embassy Detail Page
                    </div>
                    <div class="adv-glance">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe
                            nam, voluptas in aliquid dolorem ipsa similique, sunt quod ut vitae nemo necessitatibus
                            ratione natus neque eos!</p>
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>Price </th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>500 PKR</td>
                                    <td>1 Month</td>
                                </tr>

                            </tbody>
                        </table>
                        <br>
                        <div class="text-center">
                            <img src="{{url('images/promotions/verticle.jpg')}}" width="100%">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="col-md-3 pl-0">
                @include('includes.advertise-sidebar')
            </div>
        </div>
    </div>
</section>
@endsection