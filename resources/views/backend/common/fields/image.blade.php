<div class="form-body">
    <div class="form-group  {{ $errors->has($name) ? 'has-error' : ''}}" data-error-message-after=".col-sm-10">
    {!! Form::label($name,  __('backend.'.$name), ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <div class="fileinput @if (isset($document) && $document->$name )fileinput-exists @else fileinput-new @endif" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                <img src="{!! asset('backend-assets/pages/media/profile/profile.jpg') !!}" >
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;">
                @if (isset($document) && $document->$name )
                <img src='/uploads/{{$document->$name}}' >
                @endif
            </div>
            <div>
                <span class="btn btn-default btn-file">
                    <span class="fileinput-new">{{__('backend.Select image')}}</span>
                    <span class="fileinput-exists">{{__('backend.Change')}}</span>

                    {{ Form::file($name, ['class' => 'field']) }}
                </span>
                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{__('backend.Remove')}}</a>
            </div>
        </div>
        {!! $errors->first($name, '<span class="help-block">:message</span>') !!}

    </div>
</div>