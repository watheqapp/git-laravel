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
                
                <tr>
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
                </tr>
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
            </table>
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
                                                            <span class="mt-comment-author">{{$chatUser->name}}</span>
                                                            <span class="mt-comment-date">
                                                            {{date('Y-m-d h:i A', $record->timestamp)}}
                                                            </span>
                                                        </div>
                                                        <div class="mt-comment-text">
                                                         {{$record->body}}
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

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery-gmaps-latlon-picker.css')}}"/>
@endsection

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBUL_wqyqWPfjk4fYTp2TLx_A7LFUq_bDg"></script>
<script src="{{asset('js/jquery-gmaps-latlon-picker.js')}}"></script>
@endsection