@extends('admin.layout.master')
@section('title', 'Plans Permissions')
@section('pageTitle', 'Manage Plans Permissions')
@section('pageTitleSub', 'Manage')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Plans Permsison
            <small>Manage</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage Plans</li>
        </ol>
    </section>

    <section class="content">



        <div class="row">
            <div class="m1170">
                <div class="col-mda-12 box">
                    <div class="pricing-main-block top20">
                        <div class=" col-md-3 text-left color777 wow fadeInLeft" data-wow-delay="0.7s"
                            data-wow-duration="1.5s">
                            <!--<div class="per-month uppercase semibold">per month</div>-->
                            <div style="margin-top: 133.2px;"></div>
                            <div class="lh36 font13 top40 text-right">
                                @foreach($permissions as $perm)
                                <label>{{unslugperm($perm->code)}}</label><br />
                                @endforeach
                            </div>
                            <div style="margin-top: 40px;"></div>
                        </div>
                        <form method="post" action="{{url("admin/save-plan-permissions/")}}">
                            @foreach($plans as $p)
                            <input type="hidden" name="plan_id[]" value="{{$p->id}}" />
                            <div class=" col-md-3 text-center color777 wow fadeInLeft"
                                style="background-color: #ECF0F5;" data-wow-delay="0.7s" data-wow-duration="1.5s">
                                <div class="title">{{$p->name}}</div>
                            <!--     <div class="price-tbl b-radius5">RS
                                    @if(!is_null($p->plansPriceDiscounts))
                                    @foreach($p->plansPriceDiscounts->where("active", '1') as $pp)
                                    {!! $pp->isDiscountActive == 1 ? '<i
                                        style="text-decoration: line-through;">'.number_format($pp->price)."</i> / " :
                                    ""!!}{!! $pp->isDiscountActive == 1 ? number_format($pp->price - ($pp->price *
                                    $pp->discount_percentage)/100) : number_format($pp->price)!!}
                                    @endforeach
                                    @endif
                                </div> -->
                                <!--<div class="per-month uppercase semibold">per month</div>-->
                                <div style="margin-top: 23px;"></div>
                                {{csrf_field()}}
                                <div class="lh36 font13 top40 text-center" style="padding-top:94px;">
                                    @foreach($permissions as $perm)

                                    <label><input style="margin-top:0" type="checkbox" name="perm[{{$p->id}}][]" value="{{$perm->id}}"
                                            @foreach($permAssoc as $assoc)
                                            {{$assoc->plan_id == $p->id && $assoc->plans_permissions_id == $perm->id?"checked":""}}
                                            @endforeach /></label><br />
                                    @endforeach
                                </div>
                                <div style="margin-top: 40px;"></div>
                            </div>
                            @endforeach
                            <div class="clearfix"></div>
                            <input type="submit" name="submit" value="Save Permissions"
                                class="btn btn-primary pull-right" />
                            <div style="margin-top: 40px;"></div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection