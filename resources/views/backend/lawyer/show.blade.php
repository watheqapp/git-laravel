@extends('backend.layouts.app')

@section('content')


<div class="row">
    <div class="portlet light bordered">
        <h2>{{$user->name}}</h2>
        <div class="portlet-body form">
            <table class="table table-bordered">
                <tr>
                    <th class="col-md-2">{{__('backend.name')}}</th>
                    <td>{{$user->name ? $user->name : '--'}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.image')}}</th>
                    <td><img style="width: 30%" class="img-responsive" src="{{$user->image ? asset('uploads/' . $user->image) : '/backend-assets/pages/media/profile/profile.jpg'}}" /></td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.email')}}</th>
                    <td>{{$user->email ? $user->email : '--'}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.phone')}}</th>
                    <td>{{$user->phone ? $user->phone : '--'}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.lawyerType')}}</th>
                    <td><span class="label label-sm label-{{$user->lawyerType == "clerk" ? 'warning' : 'success'}}">{{$user->getLawyerTypeTxt()}}</span></td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.Location')}}</th>
                    <td>
                        @if($user->latitude && $user->longitude)
                        <fieldset class="gllpLatlonPicker">
                            <div class="gllpMap" style="margin-top: 10px; width:70%;height:300px;">{{__('backend.Location')}}</div>
                            {!! Form::hidden('lat', $user->latitude, ['class' => 'gllpLatitude']) !!}
                            {!! Form::hidden('long', $user->longitude, ['class' => 'gllpLongitude']) !!}
                            <input type="hidden" class="gllpZoom" value="15"/>
                        </fieldset>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.active')}}</th>
                    <td>{{$user->getActivateTxt()}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.created_at')}}</th>
                    <td>{{$user->created_at}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.files')}}</th>
                    <td>
                        @if($user->IDCardFile)
                        <img class="img-responsive" src="{{asset('uploads/' . $user->IDCardFile)}}" />
                        @endif

                        <br />

                        @if($user->licenseFile)
                        <img class="img-responsive" src="{{asset('uploads/' . $user->licenseFile)}}" />
                        @endif
                    </td>
                </tr>
            </table>
        </div>


    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery-gmaps-latlon-picker.css')}}"/>
@endsection

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBUL_wqyqWPfjk4fYTp2TLx_A7LFUq_bDg"></script>
<script src="{{asset('js/jquery-gmaps-latlon-picker.js')}}"></script>
@endsection