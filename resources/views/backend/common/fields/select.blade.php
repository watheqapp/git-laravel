<div class="form-group {{ $errors->has($name) ? 'has-error' : ''}}">
    <label class="control-label col-lg-2"> {{__('backend.'.$name)}} </label>
    <div class="col-sm-10">
        {!! Form::select($name, isset($value) ? $value : null, null, ['class' => 'form-control', 'data-placeholder' => __('backend.Select '.$name)]) !!}
        {!! $errors->first($name, '<span class="help-block">:message</span>') !!}
    </div>
</div>