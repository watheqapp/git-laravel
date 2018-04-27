@extends('backend.layouts.list')
@section('listTable')

    <div class="tabbable">
        <div class="row">
            <div class="col-md-2">
                <span class="label label-sm label-warning">
                    {{__('backend.Active Lawyers')}}
                    {{$totalActiveLawyer}}
                </span>
            </div>
            <div class="col-md-2">
                <span class="label label-sm label-success">
                    {{__('backend.Active Authorized')}}
                    {{$totalActiveAuthorized}}
                </span>
            </div>
        </div>
        <br/>
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="{{$listName == 'lawyer_list' ? 'active' : ''}}"><a
                        href="{{route('backend.lawyer.index')}}">{{__('backend.List Lawyers')}}</a></li>
            <li class="{{$listName == 'authorized_list' ? 'active' : ''}}"><a
                        href="{{route('backend.authorized.index')}}">{{__('backend.List authorized')}}</a></li>
        </ul>

        <div class="tab-content">
            <br/>
            <div class="clearfix"></div>
            @parent
        </div>
    </div>

@endsection