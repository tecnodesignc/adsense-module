@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('adsense::space.titles.edit space') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('admin.adsense.space.index') }}">{{ trans('adsense::space.breadcrumb.space') }}</a></li>
    <li>{{ trans('adsense::space.breadcrumb.edit space') }}</li>
</ol>
@stop

@section('styles')
    <link href="{!! Module::asset('adsense:css/nestable.css') !!}" rel="stylesheet" type="text/css" />
@stop

@section('content')
{!! Form::open(['route' => ['admin.adsense.space.update', $space->id], 'method' => 'put']) !!}
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ URL::route('admin.adsense.ad.create', [$space->id]) }}" class="btn btn-primary btn-flat">
                    <i class="fa fa-pencil"></i> {{ trans('adsense::space.button.create ad') }}
                </a>
            </div>
        </div>
        <div class="box box-primary" style="overflow: hidden;">
            <div class="box-body">
                {!! $ads !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('core::core.title.non translatable fields') }}</h3>
            </div>
            <div class="box-body">
                @include('adsense::admin.spaces.partials.edit-fields')
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
            <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
            <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.adsense.space.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('adsense::space.titles.create ad') }}</dd>
        <dt><code>b</code></dt>
        <dd>{{ trans('adsense::space.navigation.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
<script>
$( document ).ready(function() {

    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('input[type="checkbox"]').on('ifChecked', function(){
      $(this).parent().find('input[type=hidden]').remove();
    });

    $('input[type="checkbox"]').on('ifUnchecked', function(){
      var name = $(this).attr('name'),
          input = '<input type="hidden" name="' + name + '" value="0" />';
      $(this).parent().append(input);
    });
});
</script>
<script src="{!! Module::asset('adsense:js/jquery.nestable.js') !!}"></script>
<script>
$( document ).ready(function() {
    $('.dd').nestable();
    $('.dd').on('change', function() {
        var data = $('.dd').nestable('serialize');
        $.ajax({
            type: 'POST',
            url: '{{ route('api.ad.update') }}',
            data: {'space': JSON.stringify(data), '_token': '<?php echo csrf_token(); ?>'},
            dataType: 'json',
            success: function(data) {

            },
            error:function (xhr, ajaxOptions, thrownError){
            }
        });
    });
});
</script>
<script>
    $( document ).ready(function() {
        $('.jsDeleteAd').on('click', function(e) {
            var self = $(this),
                adId = self.data('item-id');
            $.ajax({
                type: 'POST',
                url: '{{ route('api.ad.delete') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    ad: adId
                },
                success: function(data) {
                    if (! data.errors) {
                        var elem = self.closest('li');
                        elem.fadeOut();
                        setTimeout(function(){
                            elem.remove()
                        }, 300);
                    }
                }
            });
        });
    });
</script>
@stop
