@if(count($space->ads) > 1)
    <a class="carousel-control-prev" href="#{{$space->system_name}}" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">{{trans('adsense::frontend.previous')}}</span>
    </a>

    <a class="carousel-control-next" href="#{{$space->system_name}}" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">{{trans('adsense::frontend.next')}}</span>
    </a>
@endif
