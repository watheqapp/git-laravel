<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <br>
        <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200">
            <li class="nav-item start active open"><a href="javascript:;" class="nav-link nav-toggle"> <em class="icon-home"></em> <span class="title">لوحة التحكم</span><span class="selected"></span></a>
                <ul class="sub-menu">
                    <li class="nav-item start "> </li>
                    <li class="nav-item start active open"> <a href="" class="nav-link "> <em class="icon-bulb"></em> <span class="title">التقارير</span><span class="selected"></span><span class="badge badge-success">1</span> </a></li>
                    <li class="nav-item start "> </li>
                </ul>
            </li>
            <li class="heading">
                <h3 class="uppercase"> {{__('backend.Users Managment')}}</h3>
            </li>
            @if(Auth::user()->hasPermission('role-client'))
            <li class="nav-item {{ strpos(Route::currentRouteName(), 'client') !== false ? 'active' : '' }} ">
                <a href="{{route('backend.client.index')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.List client')}}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasPermission('role-lawyer'))
            <li class="nav-item  {{ strpos(Route::currentRouteName(), 'lawyer') !== false ? 'active' : '' }}">
                <a href="{{route('backend.lawyer.index')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.List lawyer')}}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasPermission('role-employee'))
            <li class="nav-item  {{ strpos(Route::currentRouteName(), 'employee') !== false ? 'active' : '' }}">
                <a href="{{route('backend.employee.index')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.List employee')}}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasPermission('role-role'))
            <li class="nav-item  {{ strpos(Route::currentRouteName(), 'role') !== false ? 'active' : '' }}">
                <a href="{{route('backend.role.index')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.List role')}}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>