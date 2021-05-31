@foreach($space->ads as $index => $ad)
    @if($ad->active)
        <div class="carousel-item @if($index === 0) active @endif ">
            <img class="d-block w-100" src="{!! $ad->getImageUrl() !!}" alt="{{$ad->title}}">
            @if(!empty($ad->getLinkUrl()))
                <a href="{{$ad->getLinkUrl()}}" target="{{$ad->target}}">
                    @endif
                    @if(isset($ad->title)||isset($ad->caption) || isset($ad->custom_html))
                        <div class="carousel-caption">
                            @if(isset($ad->title))
                                @if($index==0)
                                    <h1>
                                        {{$ad->title}}
                                    </h1>
                                @else
                                    <h3>
                                        {{$ad->title}}
                                    </h3>
                                @endif
                            @endif
                            @if(isset($ad->caption))
                                <span> {{$ad->capton}}</span>
                            @endif
                            @if(isset($ad->custom_html))
                                {!! $ad->custom_html !!}
                            @endif
                        </div>
                    @endif
                    @if(!empty($ad->getLinkUrl()))
                </a>
            @endif
        </div>
    @endif
@endforeach
