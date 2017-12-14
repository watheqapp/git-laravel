@extends('auth.layouts')

@section('content')

<form class="" method="POST" action="{{ route('password.request') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">        
    <h3>{{__('backend.Reset Password')}}</h3>
    <br />

    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input class="form-control placeholder-no-fix" value="{{ old('email') }}" type="text" autocomplete="off" placeholder="{{__('backend.Email')}}" name="email" /> 
        </div>
        @if ($errors->has('email'))
        <span class="help-block">
            {{ $errors->first('email') }}
        </span>
        @endif
    </div>


    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">{{__('backend.Password')}}</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{__('backend.Password')}}" name="password" /> 
        </div>
        @if ($errors->has('password'))
        <span class="help-block">
            {{ $errors->first('password') }}
        </span>
        @endif
    </div>

    <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">{{__('backend.Password Confirmation')}}</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{__('backend.Password Confirmation')}}" name="password_confirmation" /> 
        </div>
        @if ($errors->has('password_confirmation'))
        <span class="help-block">
            {{ $errors->first('password_confirmation') }}
        </span>
        @endif
    </div>
    <div class="form-actions">
        <button type="submit" class="btn green pull-right">{{__('backend.Reset Password')}} </button>
    </div>
    <br />
</form>
@endsection
