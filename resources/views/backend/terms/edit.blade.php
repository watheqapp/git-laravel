@extends('layouts.admin')

@section('title', 'تعديل صفحة شروط الاستخدام')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-title">
                <h4><i class="icon-globe"></i> تعديل صفحة شروط الاستخدام  </h4>
                <span class="tools">
                    <a href="javascript:;" class="icon-chevron-down"></a>
                    <a href="javascript:;" class="icon-remove"></a>
                </span>                    
            </div>
            <div class="widget-body">
                @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif

                @if(Session::has('message'))
                <div class='alert alert-success'>{{__('messages.'.Session::get('message'))}}</div>
                @endif

                {!! Form::model($page, [
                'method' => 'POST',
                'url' => ['/backend/terms'],
                'class' => 'form-horizontal',
                'files' => true
                ]) !!}

                @include ('admin.terms.form', ['submitButtonText' => 'تعديل'])

                {!! Form::close() !!}

                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
    </div>
</div>
@endsection