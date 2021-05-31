@if(count($space->ads) > 1)
    <a class="carousel-control carousel-control-prev" href="#{{$space->system_name}}" role="button" data-ad="prev">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <a class="carousel-control carousel-control-next" href="#{{$space->system_name}}" role="button" data-ad="next">
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
@endif
