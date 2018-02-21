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
        $defaultFormAttribute = ['method' => 'POST', 'url' => ['/backend/price/update'], 'class' => 'form-horizontal'];
        if (count($formAttributes) > 0) {
            $defaultFormAttribute = array_merge($defaultFormAttribute, $formAttributes);
        }
        ?>
        <div class="portlet-body form">
            {!! Form::open($defaultFormAttribute) !!}
                @foreach($documents as $document)
                <div class="form-group {{ $errors->has('priceItem.'.$document->id) ? 'has-error' : ''}}">
                    {!! Form::label('priceItem['.$document->id.']', $document->nameAr, ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('priceItem['.$document->id.']', old('priceItem.'.$document->id) ? old('priceItem.'.$document->id) : $document->cost, ['class' => 'form-control', 'placeholder' =>  $document->nameAr]) !!}
                        {!! $errors->first('priceItem.'.$document->id, '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                @endforeach
                <div class="form-group {{ $errors->has('deliveryFees') ? 'has-error' : ''}}">
                    {!! Form::label('deliveryFees', __('backend.deliveryFees'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('deliveryFees', old('deliveryFees') ? old('deliveryFees')  : $setting->value, ['class' => 'form-control', 'placeholder' => __('backend.deliveryFees')]) !!}
                        {!! $errors->first('deliveryFees', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <hr />
                <div class="form-group {{ $errors->has('orderFeesRate') ? 'has-error' : ''}}">
                    {!! Form::label('orderFeesRate', __('backend.orderFeesRate'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('orderFeesRate', old('orderFeesRate') ? old('orderFeesRate')  : $orderFeesRate->value, ['class' => 'form-control', 'placeholder' => __('backend.orderFeesRate')]) !!}
                        {!! $errors->first('orderFeesRate', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('orderAllowedTimes') ? 'has-error' : ''}}">
                    {!! Form::label('orderAllowedTimes', __('backend.orderAllowedTimes'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('orderAllowedTimes', old('orderAllowedTimes') ? old('orderAllowedTimes')  : $orderAllowedTimes->value, ['class' => 'form-control', 'placeholder' => __('backend.orderAllowedTimes')]) !!}
                        {!! $errors->first('orderAllowedTimes', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                @include('backend.common.fields.submit')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
