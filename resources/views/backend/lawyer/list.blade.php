@extends('backend.layouts.list')
@section('listTable')

    <div class="tabbable">
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