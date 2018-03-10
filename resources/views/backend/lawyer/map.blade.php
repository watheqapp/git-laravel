@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="portlet light blawyered">
            <div class="portlet-title">
                <div class="caption"><em class="icon-bar-chart font-dark hide"></em> <span
                            class="caption-subject font-dark bold uppercase">{{__('backend.Lawyer concentration map')}}</span>
                    <span
                            class="caption-helper"> <span class="badge badge-danger">{{count($lawyers)}}</span></span></div>
            </div>
            <div class="portlet-body">
                <div id="map" style=" height: 500px;">
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>

@endsection

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBUL_wqyqWPfjk4fYTp2TLx_A7LFUq_bDg&language=ar"></script>
    <script type="text/javascript" src="{{asset('backend-assets/apps/scripts/jquery.googlemap.js')}}"></script>
    <script>
        $(function () {
            $("#map").googleMap({
                zoom: 10, // Initial zoom level (optional)
                coords: [24.774265, 46.738586], // Map center (optional)
            });

            @foreach($lawyers as  $lawyer)
                $("#map").addMarker({
                    coords: ['{{$lawyer[0]}}', '{{$lawyer[1]}}']
                });
            @endforeach
        })
    </script>
@endsection