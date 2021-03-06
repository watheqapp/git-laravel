<div class="form-group {{ $errors->has($name) ? 'has-error' : ''}}">
    {!! Form::label($name, __('backend.'.$name), ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::password($name, ['class' => 'form-control', 'placeholder' =>  __('backend.'.$name)]) !!}
        {!! $errors->first($name, '<span class="help-block">:message</span>') !!}
    </div>
</div>