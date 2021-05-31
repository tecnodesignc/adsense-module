@foreach($space->ads as $index => $ad)
    @if($ad->active)
        <div class="carousel-item @if($index ===0) active @endif " style="margin: 10px 0" data-interval="10000">
            @if(!empty($ad->external_image_url))
                @if(strpos($ad->external_image_url,"youtube.com"))
                    <iframe width="100%" src="{{$ad->external_image_url }}"
                            frameborder="0" allowfullscreen></iframe>
                @else
                    @if(strpos($ad->external_image_url,".mp4"))
                        <video class="img-responsive center-block" loop controls="false">
                            <source src="{{$ad->external_image_url}}" type="video/mp4">
                        </video>
                    @else
                        <img class="img-responsive" src="{!! $ad->external_image_url!!}" alt="{{ $ad->title }}">
                    @endif
                @endif

            @elseif( isset($ad->custom_html) && !empty($ad->custom_html))
                {!! $ad->custom_html !!}
            @else
                @if(!empty($ad->getLinkUrl()))
                    <a href="{{$ad->getLinkUrl()}}" target="{{$ad->target}}">
                        @endif
                        <img class="img-fluid" src="{!! $ad->getImageUrl() !!}"
                             alt="{{ $ad->title?? setting('core::site-description')}}">
                        @if(!empty($ad->getLinkUrl()))
                    </a>
                @endif
            @endif
            <p style="font-size: 10px; text-align: center;margin: 0 auto 10px">pulicidad</p>
        </div>
    @endif
@endforeach
