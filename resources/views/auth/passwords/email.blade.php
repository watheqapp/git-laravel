@extends('auth.layouts')

@section('content')

<form class="" method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}
    <h3>{{__('backend.Forgot your password ?')}}</h3>
    <p>{{__('backend.Enter your e-mail address below to reset your password')}}</p>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
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

    <div class="form-actions">
        <a type="button" href="{{url('login')}}" id="back-btn" class="btn grey-salsa btn-outline"> {{__('backend.Back')}} </a>
        <button type="submit" class="btn green pull-right">{{__('backend.Send Password Reset Link')}} </button>
    </div>
</form>

@endsection


