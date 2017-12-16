<div class="page-head">
    <div class="page-title">
        <h1> {{__('backend.'.$pageLable)}} <small></small>&nbsp;</h1>
    </div>
</div>

<ul class="page-breadcrumb breadcrumb">
    <li> <a href="{{route('backend.home')}}">{{__('backend.Dashboard')}}</a>&nbsp;<em class="fa fa-circle"></em></li>
    @if(!empty($links))
        @foreach($links as $link)
        <li>
            @if(isset($link['route']) && $link['route'])
            <li> <a href="{{$link['route']}}">{{__('backend.'.$link['name'])}}</a>&nbsp;<em class="fa fa-circle"></em></li>
            @else
            <span class="active">{{__('backend.'.$link['name'])}}</span>
            @endif
        </li>
        @endforeach
    @endif
</ul>