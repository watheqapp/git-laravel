@extends('auth.layouts')

@section('content')

<form class="" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <h3 class="form-title">{{__('backend.Login to your account')}}</h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span> Enter any username and password. </span>
    </div>
    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">{{__('backend.Email')}}</label>
        <div class="input-icon">
            <i class="fa fa-user"></i>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="{{__('backend.Email')}}" name="email" /> 
            @if ($errors->has('email'))
            <span class="help-block">
                {{ $errors->first('email') }}
            </span>
            @endif
        </div>

    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">{{__('backend.Password')}}</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{__('backend.Password')}}" name="password" /> 
            @if ($errors->has('password'))
            <span class="help-block">
                {{ $errors->first('password') }}
            </span>
            @endif
        </div>
    </div>

<!--    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
        <div class="">
            {!! NoCaptcha::display([], 'ar') !!}


            @if ($errors->has('g-recaptcha-response'))
            <span class="help-block">
                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <div class="g-recaptcha" data-sitekey="6LcH9TwUAAAAANRweakibi5mGLN8eRTpH8zrxR6E" data-theme="light" ></div>
    </div>-->


    <div class="form-actions">
        <label class="rememberme mt-checkbox mt-checkbox-outline">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} /> {{__('backend.Remember me')}}
                   <span></span>
        </label>
        <button type="submit" class="btn green pull-right"> {{__('backend.Login')}} </button>
    </div>
    <div class="forget-password">
        <a href="{{ route('password.request') }}" id="forget-password"> {{__('backend.Forgot your password ?')}} </a></p>
    </div>
</form>
@endsection
