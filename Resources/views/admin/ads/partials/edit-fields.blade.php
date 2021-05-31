<div class="form-group">
    <label for="target">{{ trans('adsense::ads.form.target') }}</label>
    <select class="form-control" name="target" id="target">
        <option value="_self" {{ $ad->target == '_self' ? 'selected' : '' }}>{{ trans('adsense::ads.form.same tab') }}</option>
        <option value="_blank" {{ $ad->target == '_blank' ? 'selected' : '' }}>{{ trans('adsense::ads.form.new tab') }}</option>
    </select>
</div>

<div class="form-group{{ $errors->has("external_image_url") ? ' has-error' : '' }}">
    {!! Form::label("external_image_url", trans('adsense::space.form.external image url')) !!}
    {!! Form::text("external_image_url", old("external_image_url", $ad->external_image_url), ['class' => 'form-control', 'placeholder' => trans('adsense::space.form.placeholder.external image url')]) !!}
    {!! $errors->first("external_image_url", '<span class="help-block">:message</span>') !!}
</div>

@include('media::admin.fields.file-link', [
    'entityClass' => 'Modules\\\\Adsense\\\\Entities\\\\Ad',
    'entityId' => $ad->id,
    'zone' => 'adImage'
])
