@extends('backend.layouts.app')

@section('content')


<div class="row">
    <div class="portlet light bordered">
        <h2>{{$order->name}}</h2>
        <div class="portlet-body form">
            <table class="table table-bordered">
                <tr>
                    <th class="col-md-2">{{__('backend.status')}}</th>
                    <td>{{__('backend.'.$order->status)}}</span></td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.client_id')}}</th>
                    <td>{{$order->client ? $order->client->name : '--'}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.lawyer_id')}}</th>
                    <td>{{$order->lawyer ? $order->lawyer->name : '--'}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.category_id')}}</th>
                    <td>{{$order->category ? $order->category->nameAr : '--'}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.cost')}}</th>
                    <td>{{$order->cost.' '. __('backend.SAR')}}</span></td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.cost')}}</th>
                    <td>{{__('backend.'.$order->delivery)}}</span></td>
                </tr>
                
                @if($order->clientName)
                <tr>
                    <th class="col-md-2">{{__('backend.clientName')}}</th>
                    <td>{{$order->clientName}}</span></td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.clientNationalID')}}</th>
                    <td>{{$order->clientNationalID}}</span></td>
                </tr>
                @endif
                
                @if($order->representativeName)
                <tr>
                    <th class="col-md-2">{{__('backend.representativeName')}}</th>
                    <td>{{$order->representativeName}}</span></td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.representativeNationalID')}}</th>
                    <td>{{$order->representativeNationalID}}</span></td>
                </tr>
                @endif
                
                @if($order->status == 'Closed')
                <tr>
                    <th class="col-md-2">{{__('backend.clientRate')}}</th>
                    <td>{{$order->clientRate}}</span></td>
                </tr>
                @endif
                
                <!-- <tr>
                    <th class="col-md-2">{{__('backend.Client Location')}}</th>
                    <td>
                        @if($order->latitude && $order->longitude)
                        <fieldset class="gllpLatlonPicker">
                            <div class="gllpMap" style="margin-top: 10px; width:70%;height:300px;">{{__('backend.Location')}}</div>
                            {!! Form::hidden('lat', $order->latitude, ['class' => 'gllpLatitude']) !!}
                            {!! Form::hidden('long', $order->longitude, ['class' => 'gllpLongitude']) !!}
                            <input type="hidden" class="gllpZoom" value="15"/>
                        </fieldset>
                        @endif
                    </td>
                </tr> -->
                <tr>
                    <th class="col-md-2">{{__('backend.created_at')}}</th>
                    <td>{{$order->created_at}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.accepted_at')}}</th>
                    <td>{{$order->accepted_at}}</td>
                </tr>
                <tr>
                    <th class="col-md-2">{{__('backend.closed_at')}}</th>
                    <td>{{$order->closed_at}}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="order-lawyers" style=" height: 500px;"></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-bubbles font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">الموثقين اﻷقرب للطلب</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>المسافة</th>
                                    <th>الجوال</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($OutLawyers) == 0)
                                    <tr>
                                        <td colspan="3">لم تتوفر نتائج</td>
                                    </tr>
                                @endif
                                @foreach ($OutLawyers as $lawyer)
                                    <tr>
                                        <td>{{$lawyer->name}}</td>
                                        <td>{{Assets::calculateOrderDistance([$order->latitude, $order->longitude], [$lawyer->latitude, $lawyer->longitude])}} {{__('backend.Kilo')}}</td>
                                        <td>{{$lawyer->phone}}</td>
                                        <td>
                                            <a class="btn btn-sm blue btn-outline dev-assign-lawyer-action" title="{{__('backend.Assign lawyer')}}" href="javascript:void(0)" data-href="{{route('backend.order.assignLawyerModal', ['id' => $lawyer->id])}}">
                                                <i class="fa fa-user"></i>
                                                {{__('backend.Assign lawyer')}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-bubbles font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">المحادثات</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_comments_1" style="max-height: 300px;overflow-y: scroll;">
                                @if(!$chat)
                                    <?php $chat = [] ?>
                                    <p>لا توجد محادثات</p>
                                @endif
                                @foreach($chat as $record)
                                <div class="mt-comments">
                                    <div class="mt-comment">
                                        <div class="mt-comment-img">
                                            @if($order->lawyer && $order->lawyer->image && $order->lawyer->id == $record->from)
                                                <img class="img-responsive" src="{{asset('uploads/'.$order->lawyer->image)}}" />
                                            @elseif($order->client && $order->client->image && $order->client->id == $record->from)
                                                <img class="img-responsive" src="{{asset('uploads/'.$order->client->image)}}" />
                                            @else
                                                <img class="img-responsive" src="{{asset('backend-assets/pages/media/profile/profile.jpg')}}"> 
                                            @endif
                                        </div>
                                        <?php $chatUser = $order->client->id == $record->from ? $order->client : $order->lawyer ?>
                                        <div class="mt-comment-body">
                                            <div class="mt-comment-info">
                                                <span class="mt-comment-author">{{$chatUser ?$chatUser->name : ''}}</span>
                                                <span class="mt-comment-date">
                                                {{$record->timestamp ? date('Y-m-d h:i A', $record->timestamp) : ''}}
                                                </span>
                                            </div>
                                            <div class="mt-comment-text">
                                             {{$record->body ? $record->body : ''}}
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection


@section('js')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUL_wqyqWPfjk4fYTp2TLx_A7LFUq_bDg&callback=initMap"></script>
<script>

    orderCenter = {lat: parseFloat('{{$order->latitude}}'), lng: parseFloat('{{$order->longitude}}')};

    function initMap() {
        var map = new google.maps.Map(document.getElementById('order-lawyers'), {
          zoom: 10,
          center: orderCenter,
          mapTypeId: 'terrain'
        });

        var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';

        new google.maps.Marker({
            position: new google.maps.LatLng(orderCenter),
            map: map,
            icon: image
        });

        @foreach ($OutLawyers as $lawyer)
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng({lat: parseFloat('{{$lawyer->latitude}}'), lng: parseFloat('{{$lawyer->longitude}}')}),
                map: map,
                title: '{{$lawyer->name}}'

            });
        @endforeach


        @foreach ($inLawyers as $inLawyer)
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng({lat: parseFloat('{{$inLawyer->latitude}}'), lng: parseFloat('{{$inLawyer->longtitude}}')}),
                map: map,
                title: '{{$inLawyer->name}}'

            });
        @endforeach


        // Add the circle for this city to the map.
        var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: orderCenter,
            radius: 20000 // in meters
          });
        }
</script>
@endsection