@if(count($space->ads) > 1)
    <ol class="carousel-indicators">
        @foreach($space->ads as $index => $ad)
            <li data-target="#{{ $space->system_name }}" data-slide-to="{{ $index }}" class="@if($index === 0) active @endif"></li>
        @endforeach
    </ol>
@endif
