<div id="{{$space->system_name}}" class="carousel ad" data-ride="carousel" >
    {{--@include('space.main.indicators', ['space' => $space])--}}
    <div class="carousel-inner">
        @include('adsense::frontend.main.ads', ['space' => $space])
    </div>
    @include('adsense::frontend.main.controls', ['space' => $space])
</div>
