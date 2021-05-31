<div class='form-group{{ $errors->has("{$lang}[title]") ? ' has-error' : '' }}'>
    {!! Form::label("{$lang}[title]", trans('adsense::space.form.title')) !!}
    {!! Form::text("{$lang}[title]", old("{$lang}[title]"), ['class' => 'form-control', 'placeholder' => trans('adsense::space.form.title'), 'autofocus']) !!}
    {!! $errors->first("{$lang}[title]", '<span class="help-block">:message</span>') !!}
</div>
<div class='form-group{{ $errors->has("{$lang}[caption]") ? ' has-error' : '' }}'>
    {!! Form::label("{$lang}[caption]", trans('adsense::space.form.caption')) !!}
    {!! Form::text("{$lang}[caption]", old("{$lang}[caption]"), ['class' => 'form-control', 'placeholder' => trans('adsense::space.form.caption'), 'autofocus']) !!}
    {!! $errors->first("{$lang}[caption]", '<span class="help-block">:message</span>') !!}
</div>
<div class="form-group">
    {!! Form::label("{$lang}[uri]", trans('adsense::space.form.uri')) !!}
    <div class='input-group{{ $errors->has("{$lang}[uri]") ? ' has-error' : '' }}'>
        <span class="input-group-addon">/{{ $lang }}/</span>
        {!! Form::text("{$lang}[uri]", old("{$lang}[uri]"), ['class' => 'form-control', 'placeholder' => trans('adsense::space.form.uri')]) !!}
        {!! $errors->first("{$lang}[uri]", '<span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="form-group{{ $errors->has("{$lang}[url]") ? ' has-error' : '' }}">
    {!! Form::label("{$lang}[url]", trans('adsense::space.form.url')) !!}
    {!! Form::text("{$lang}[url]", old("{$lang}[url]"), ['class' => 'form-control', 'placeholder' => trans('adsense::space.form.url')]) !!}
    {!! $errors->first("{$lang}[url]", '<span class="help-block">:message</span>') !!}
</div>

<div class="checkbox">
    <label for="{{$lang}}[active]">
        <input id="{{$lang}}[active]"
                name="{{$lang}}[active]"
                type="checkbox"
                class="flat-blue"
                value="1" />
        {{ trans('adsense::space.form.active') }}
    </label>
</div>

<div class="form-group{{ $errors->has("{$lang}[custom_html]") ? ' has-error' : '' }}">
    {!! Form::label("{$lang}[custom_html]", trans('adsense::ads.form.custom html')) !!}
    {!! Form::textarea("{$lang}[custom_html]", old("{$lang}[custom_html]"), ['class' => 'form-control', 'placeholder' => trans('adsense::ads.form.custom html')]) !!}
    {!! $errors->first("{$lang}[custom_html]", '<span class="help-block">:message</span>') !!}
</div>
