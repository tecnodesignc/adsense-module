{{--@php
    $rand=rand(0,count($space->ads)-1)
@endph--}}
<figure class="op-ad">
<div id="{{$space->system_name}}" class="carousel ad" data-ride="carousel">
    @include('adsense::frontend.bootstrap.indicators', ['space' => $space])
    <div class="carousel-inner" role="listbox">
        @include('adsense::frontend.bootstrap.ads', ['space' => $space,'options'=>$options])
    </div>
    @include('adsense::frontend.bootstrap.controls', ['space' => $space])
</div>
</figure>
