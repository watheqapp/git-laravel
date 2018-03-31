<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <br>
        <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200">
            <li class="nav-item start active open"><a href="javascript:;" class="nav-link nav-toggle"> <em class="icon-home"></em> <span class="title">{{__('backend.Dashboard')}}</span><span class="selected"></span></a>
                <ul class="sub-menu">
                    <li class="nav-item start "> </li>
                    <li class="nav-item start {{ strpos(Route::currentRouteName(), 'backend.map') !== false ? 'active open' : '' }}"> <a href="{{url('/backend')}}" class="nav-link "> <em class="icon-bulb"></em> <span class="title">{{__('backend.Statistics')}}</span><span class="selected"></span> </a></li>
                    <li class="nav-item start {{ strpos(Route::currentRouteName(), 'order.map') !== false ? 'active open' : '' }} "> <a href="{{route('backend.order.map')}}" class="nav-link "> <em class="icon-map"></em> <span class="title">{{__('backend.Order concentration map')}}</span><span class="selected"></span> </a></li>
                    <li class="nav-item start {{ strpos(Route::currentRouteName(), 'client.map') !== false ? 'active open' : '' }} "> <a href="{{route('backend.client.map')}}" class="nav-link "> <em class="icon-map"></em> <span class="title">{{__('backend.Client concentration map')}}</span><span class="selected"></span> </a></li>
                    <li class="nav-item start {{ strpos(Route::currentRouteName(), 'lawyer.map') !== false ? 'active open' : '' }} "> <a href="{{route('backend.lawyer.map')}}" class="nav-link "> <em class="icon-map"></em> <span class="title">{{__('backend.Lawyer concentration map')}}</span><span class="selected"></span> </a></li>
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
                    
                </a>
            </li>
            @endif
            @if(Auth::user()->hasPermission('role-lawyer'))
            <li class="nav-item  {{ strpos(Route::currentRouteName(), 'lawyer') !== false ? 'active' : '' }}">
                <a href="{{route('backend.lawyer.index')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.List lawyer')}}</span>
                    
                </a>
            </li>
            @endif
            @if(Auth::user()->hasPermission('role-employee'))
            <li class="nav-item  {{ strpos(Route::currentRouteName(), 'employee') !== false ? 'active' : '' }}">
                <a href="{{route('backend.employee.index')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.List employee')}}</span>
                    
                </a>
            </li>
            @endif
            @if(Auth::user()->hasPermission('role-role'))
            <li class="nav-item  {{ strpos(Route::currentRouteName(), 'role') !== false ? 'active' : '' }}">
                <a href="{{route('backend.role.index')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.List role')}}</span>
                    
                </a>
            </li>
            @endif
            
            
            <li class="heading">
                <h3 class="uppercase"> {{__('backend.Orders Managment')}}</h3>
            </li>
            @if(Auth::user()->hasPermission('role-order'))
            <li class="nav-item {{ strpos(Route::currentRouteName(), 'new') !== false ? 'active' : '' }} ">
                <a href="{{route('backend.order.new')}}" class="nav-link"> 
                    <em class="icon-camcorder"></em> 
                    <span class="title">{{__('backend.List new order')}}</span>
                    <span class="badge badge-success">{{Assets::newOrderCount()}}</span>
                </a>
            </li>
            <li class="nav-item {{ strpos(Route::currentRouteName(), 'pending') !== false ? 'active' : '' }} ">
                <a href="{{route('backend.order.pending')}}" class="nav-link"> 
                    <em class="icon-camcorder"></em> 
                    <span class="title">{{__('backend.List pending order')}}</span>
                    <span class="badge badge-success">{{Assets::pendingOrderCount()}}</span>
                </a>
            </li>
            <li class="nav-item {{ strpos(Route::currentRouteName(), 'closed') !== false ? 'active' : '' }} ">
                <a href="{{route('backend.order.closed')}}" class="nav-link"> 
                    <em class="icon-camcorder"></em> 
                    <span class="title">{{__('backend.List closed order')}}</span>
                    <span class="badge badge-success">{{Assets::closedOrderCount()}}</span>
                </a>
            </li>
            <li class="nav-item {{ strpos(Route::currentRouteName(), 'removed') !== false ? 'active' : '' }} ">
                <a href="{{route('backend.order.removed')}}" class="nav-link">
                    <em class="icon-camcorder"></em>
                    <span class="title">{{__('backend.List removed order')}}</span>
                    <span class="badge badge-success">{{Assets::removedOrderCount()}}</span>
                </a>
            </li>
            <li class="nav-item {{ strpos(Route::currentRouteName(), 'support') !== false ? 'active' : '' }} ">
                <a href="{{route('backend.order.support')}}" class="nav-link"> 
                    <em class="icon-camcorder"></em> 
                    <span class="title">{{__('backend.List support order')}}</span>
                    <span class="badge badge-success">{{Assets::supportOrderCount()}}</span>
                </a>
            </li>
            @endif


            <li class="heading">
                <h3 class="uppercase"> {{__('backend.Contact us messages')}}</h3>
            </li>
            @if(Auth::user()->hasPermission('role-clientContact'))
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'clientContact') !== false ? 'active' : '' }} ">
                    <a href="{{route('backend.clientContact.index')}}" class="nav-link">
                        <em class="icon-camcorder"></em>
                        <span class="title">{{__('backend.List clientContact')}}</span>
                        <span class="badge badge-success">{{Assets::clientContactCount()}}</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->hasPermission('role-lawyerContact'))
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'lawyerContact') !== false ? 'active' : '' }} ">
                    <a href="{{route('backend.lawyerContact.index')}}" class="nav-link">
                        <em class="icon-camcorder"></em>
                        <span class="title">{{__('backend.List lawyerContact')}}</span>
                        <span class="badge badge-success">{{Assets::lawyerContactCount()}}</span>
                    </a>
                </li>
            @endif
            
            <li class="heading">
                <h3 class="uppercase"> {{__('backend.Setting Managment')}}</h3>
            </li>
            @if(Auth::user()->hasPermission('role-prices'))
            <li class="nav-item  {{ strpos(Route::currentRouteName(), 'price') !== false ? 'active' : '' }}">
                <a href="{{route('backend.price.edit')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.Edit price')}}</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasPermission('role-social'))
            <li class="nav-item  {{ strpos(Route::currentRouteName(), 'social') !== false ? 'active' : '' }}">
                <a href="{{route('backend.social.edit')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.Edit social')}}</span>
                </a>
            </li>
            @endif
            
            @if(Auth::user()->hasPermission('role-pages'))
            <li class="nav-item  {{ strpos(Route::currentRouteName(), 'pages') !== false ? 'active' : '' }}">
                <a href="{{route('backend.pages.edit')}}" class="nav-link"> 
                    <em class="icon-users"></em> 
                    <span class="title">{{__('backend.Edit pages')}}</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>