<div class='form-group{{ $errors->has('name') ? ' has-error' : '' }}'>
    {!! Form::label('name', trans('adsense::space.form.name')) !!}
    {!! Form::text('name', old('name', $space->name), ['class' => 'form-control', 'placeholder' => trans('adsense::space.form.name')]) !!}
    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has('system_name') ? ' has-error' : '' }}'>
    {!! Form::label('system_name', trans('adsense::space.form.system name')) !!}
    {!! Form::text('system_name', old('system_name', $space->system_name), ['class' => 'form-control', 'placeholder' => trans('adsense::space.form.system name')]) !!}
    {!! $errors->first('System Name', '<span class="help-block">:message</span>') !!}
</div>

<div class="checkbox">
    <label for="active">
        <input id="active"
               name="active"
               type="checkbox"
               class="flat-blue"
               {{ (empty(old('active', $space->active))) ?: 'checked' }}
               value="1" />
        {{ trans('adsense::space.form.active') }}
    </label>
</div>
