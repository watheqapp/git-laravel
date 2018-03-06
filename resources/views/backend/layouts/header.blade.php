<!DOCTYPE html>
<html dir="rtl" lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <title>{{config('app.name')}} - لوحة التحكم</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet"
          type="text/css">
    <link href="{{asset('backend-assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{asset('backend-assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{asset('backend-assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{asset('backend-assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css')}}"
          rel="stylesheet" type="text/css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{asset('backend-assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}"
          rel="stylesheet" type="text/css">
    <link href="{{asset('backend-assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend-assets/global/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{asset('backend-assets/global/plugins/jqvmap/jqvmap/jqvmap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend-assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{asset('backend-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('backend-assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{asset('backend-assets/global/css/components-rounded-rtl.min.css')}}" rel="stylesheet"
          id="style_components" type="text/css">
    <link href="{{asset('backend-assets/global/css/plugins-rtl.min.css')}}" rel="stylesheet" type="text/css">
    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{asset('backend-assets/layouts/layout4/css/layout-rtl.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend-assets/layouts/layout4/css/themes/default-rtl.min.css')}}" rel="stylesheet"
          type="text/css" id="style_color">
    <link href="{{asset('backend-assets/layouts/layout4/css/custom-rtl.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend-assets/apps/css/custom-rtl.css')}}" rel="stylesheet" type="text/css">
    <!-- END THEME LAYOUT STYLES -->

    @yield('css')
    <style type="text/css">
        .dashboard-stat .details {
            right: 15px;
            padding-right: 15px;
        }

        .dashboard-stat .details .number, .dashboard-stat .details .desc {
            text-align: right;
        }

        .lawyer-notlogin {
            background: #ccc !important;
        }

        .lawyer-login {
            background: #369636 !important;
        }
    </style>

    <link rel="shortcut icon" href="favicon.ico">
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner ">
        <div class="page-logo">
            <a href="{{url('backend')}}">
            <!--                        {{config('app.name')}}-->
                <img class="img-responsive" width="106" height="20"
                     src="{{asset('backend-assets//layouts/layout4/img/playstore-icon.png')}}" alt="logo"
                     class="logo-default">
            </a>
            <div class="menu-toggler sidebar-toggler">&nbsp;&nbsp;&nbsp;&nbsp; <br>
            </div>
        </div>
        <!-- <div class="page-actions">
            <div class="btn-group">
                <button type="button" class="btn red-haze btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <span class="hidden-sm hidden-xs">عمليات&nbsp;</span>
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li> <a href="javascript:;"> <i class="icon-docs"></i> New Post </a> </li>
                    <li> <a href="javascript:;"> <i class="icon-tag"></i> New Comment </a> </li>
                    <li> <a href="javascript:;"> <i class="icon-share"></i> Share </a> </li>
                    <li class="divider"> </li>
                    <li> <a href="javascript:;"> <i class="icon-flag"></i> Comments <span class="badge badge-success">4</span> </a> </li>
                    <li> <a href="javascript:;"> <i class="icon-users"></i> Feedbacks <span class="badge badge-danger">2</span> </a> </li>
                </ul>
            </div>
        </div> -->
        &nbsp;
        <div class="page-top">
            <form class="search-form" action="page_general_search_2.html" method="GET">
                &nbsp;<span class="input-group-btn"><a href="javascript:;" class="btn submit">
                            </a> </span></form>
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide"></li>
                    &nbsp;
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark"
                        id="header_notification_bar">
                        <a href="javascript:;" class="dropdown-toggle dev-notification-btn" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <i class="icon-bell"></i>
                            <span class="badge badge-success"> {{Assets::countNewlAdminNotifications()}} </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>
                                    <span class="bold">{{Assets::countNewlAdminNotifications()}} </span> {{__('backend.notifications')}} {{__('backend.pending')}}
                                </h3>
                                <a href="{{route('backend.notification.index')}}">{{__('backend.view all')}}</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;"
                                    data-handle-color="#637283">
                                    @foreach(Assets::latestAdminNotifications() as $notification)
                                    <li>
                                        <a href="{{route('backend.order.show', ['id' => $notification->order_id])}}">
                                            <span class="time">{{$notification->created_at->diffForHumans()}}</span>
                                            <span class="details">
                                            <span class="label label-sm label-icon label-success">
                                                <i class="fa fa-plus"></i>
                                            </span> {{$notification->message}} </span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <li class="separator hide"></li>
                    <!-- BEGIN INBOX DROPDOWN -->
                    &nbsp;&nbsp;&nbsp;
                    <li class="dropdown dropdown-user dropdown-dark"><a href="javascript:;" class="dropdown-toggle"
                                                                        data-toggle="dropdown" data-hover="dropdown"
                                                                        data-close-others="true">
                            <span class="username username-hide-on-mobile"> علي </span>
                            <img class="img-circle" src="{{asset('backend-assets/layouts/layout4/img/avatar9.jpg')}}">
                        </a>
                        <!-- <ul class="dropdown-menu dropdown-menu-default">
                            <li> <a href="page_user_profile_1.html"> <i class="icon-user"></i>
                                    My Profile </a> </li>
                            <li> <a href="app_calendar.html"> <i class="icon-calendar"></i>
                                    My Calendar </a> </li>
                            <li> <a href="app_inbox.html"> <i class="icon-envelope-open"></i>
                                    My Inbox <span class="badge badge-danger"> 3 </span> </a>
                            </li>
                            <li> <a href="app_todo_2.html"> <i class="icon-rocket"></i>
                                    My Tasks <span class="badge badge-success"> 7 </span> </a>
                            </li>
                            <li class="divider"> </li>
                            <li> <a href="page_user_lock_1.html"> <i class="icon-lock"></i>
                                    Lock Screen </a> </li>
                            <li> <a href="page_user_login_1.html"> <i class="icon-key"></i>
                                    Log Out </a> </li>
                        </ul> -->
                    </li>
                    &nbsp;&nbsp;
                    <li class="dropdown dropdown-extended quick-sidebar-toggler"
                        onclick="window.location.href ='{{route("logout")}}'">
                        <span class="sr-only">Toggle Quick Sidebar</span>
                        <i class="icon-logout"></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix">&nbsp;</div>






