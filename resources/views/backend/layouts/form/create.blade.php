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
        $defaultFormAttribute = ['method' => 'POST', 'url' => ['/backend/' . $className . '/store'], 'class' => 'form-horizontal'];
        if (count($formAttributes) > 0) {
            $defaultFormAttribute = array_merge($defaultFormAttribute, $formAttributes);
        }
        ?>

        <div class="portlet-body form">
            {!! Form::open($defaultFormAttribute) !!}
            @include ('backend.'.$className.'.form')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

