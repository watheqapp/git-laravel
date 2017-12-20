@extends('backend.layouts.form.form')

@section('form')
<div class="row">
    <div class="portlet light bordered">
        @if(Session::has('success'))
        <div class="text-center alert alert-success no-border">
            <button type="button" class="close" data-dismiss="alert">
                <span>×</span>
                <span class="sr-only">Close</span></button>
            {{__('backend.'.Session::get('success'))}}
        </div>
        @endif

        @if(Session::has('error'))
        <div class="text-center alert alert-danger no-border">
            <button type="button" class="close" data-dismiss="alert">
                <span>×</span>
                <span class="sr-only">Close</span></button>
            {{__('backend.'.Session::get('error'))}}
        </div>
        @endif

        <?php
        $defaultFormAttribute = ['method' => 'POST', 'url' => ['/backend/social/update'], 'class' => 'form-horizontal'];
        if (count($formAttributes) > 0) {
            $defaultFormAttribute = array_merge($defaultFormAttribute, $formAttributes);
        }
        ?>
        <div class="portlet-body form">
            {!! Form::open($defaultFormAttribute) !!}
                @foreach($documents as $document)
                <div class="form-group {{ $errors->has('socialItem.'.$document->id) ? 'has-error' : ''}}">
                    {!! Form::label('socialItem['.$document->id.']', __('backend.'.$document->setting), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('socialItem['.$document->id.']', old('socialItem.'.$document->id) ? old('socialItem.'.$document->id) : $document->value, ['class' => 'form-control', 'placeholder' =>  __('backend.'.$document->setting)]) !!}
                        {!! $errors->first('socialItem.'.$document->id, '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                
                @endforeach
                @include('backend.common.fields.submit')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
