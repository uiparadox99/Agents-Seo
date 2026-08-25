 @foreach($agentsPackages as $ap)
 <div class="col-md-4 ">
    <div class="detail-package-box ">
        <a href="{{ url($ap->slug) }}" style="text-decoration: none;">
            <p class=" m-0 p-2 agent-name text-capitalize"> {{strtolower($ap->business_name)}} <span style="float: right;">Rs.{{$ap->price}}</span></p>
            @if(empty($ap->image))
            <img src="{{url('images/placeholder.jpg')}}" >
            @else
            <img src="{{url('storage/uploads/packages/'.$ap->image)}}"  alt="{{!empty($ap->image_alt)?$ap->image_alt:$ap->name}}" >
            @endif
            
            <div class="p-1  detail">
                <h4 class="m-0 p-0 text-center"><!-- <small><i class="fa fa-map-marker-alt"></i></small> -->
                    {{str_limit($ap->name,35)}}</h4>
                    <!-- <p class="m-0 text-center">{{substr(str_replace('<br />','',$ap->content1),0,100)}}</p> -->
                    <!-- <p class="m-0">Umrah Packages</p> -->
                </div>

            </a>
        </div>
    </div>

    @endforeach