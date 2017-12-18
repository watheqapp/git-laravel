<div class="control-group {{ $errors->has('content') ? 'has-error' : ''}}">
    {!! Form::label('content', 'محتوى الصفحة', ['class' => 'control-label']) !!}
    <div class="controls">
        {!! Form::textarea('content', null, ['id' => 'bodyField', 'class' => 'input-xxlarge']) !!}
        {!! $errors->first('content', '<span class="help-inline">:message</span>') !!}
    </div>
</div>

@ckeditor('bodyField')

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'ادخال', ['class' => 'btn btn-primary btn-large']) !!}
    </div>
</div>