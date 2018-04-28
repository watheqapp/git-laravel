@extends('email.base')
<tr>
    <td class="wrapper" dir="rtl">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <img width="200px" src="{{asset('backend-assets//layouts/layout4/img/playstore-icon.png')}}"
                         style="display: block; margin: 0 auto"/>
                    <hr>
                </td>
            </tr>
            <tr style="text-align: center;">
                <td>
                    <p>
                        <strong>
                            مرحبا {!! $username !!}!
                        </strong>
                    </p>
                    <p>{{ $body }}</p>
                    <p>
                        <a href="{{route('backend.order.show', ['id' => $order->id])}}">رابط الطلب</a>
                    </p>
                    <br />
                    <table style="width: 50%; margin: 0 auto">
                        <tr>
                            <th style="width: 150px;">{{__('backend.client_id')}}</th>
                            <td>{{$order->client ? $order->client->name : '--'}}</td>
                        </tr>
                        <tr>
                            <th style="width: 150px;">{{__('backend.lawyer_id')}}</th>
                            <td>{{$order->lawyer ? $order->lawyer->name : '--'}}</td>
                        </tr>
                        <tr>
                            <th style="width: 150px;">{{__('backend.category_id')}}</th>
                            <td>{{$order->category ? $order->category->nameAr : '--'}}</td>
                        </tr>
                        <tr>
                            <th style="width: 150px;">{{__('backend.cost')}}</th>
                            <td>{{$order->cost.' '. __('backend.SAR')}}</span></td>
                        </tr>
                        <tr>
                            <th style="width: 150px;">{{__('backend.created_at')}}</th>
                            <td>{{$order->created_at}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>