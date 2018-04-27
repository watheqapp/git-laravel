@extends('email.base')
<tr>
    <td class="wrapper" dir="rtl">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <img src="{{asset('backend-assets//layouts/layout4/img/playstore-icon.png')}}" style="display: block; margin: 0 auto"/>
                    <hr>
                </td>
            </tr>
            <tr>
                <td>
                    <p>مرحبا {!! $username !!}!</p>
                    <p>{{ $body }}</p>
                    <p>

                    <a href="{{route('backend.order.show', ['id' => $order->id])}}">رابط الطلب</a>
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>