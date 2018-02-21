@extends('backend.layouts.app')


@section('jsBefrorDashboard')

<script>

var orders = JSON.parse("{{$ordersByDaysStatistics}}".replace(/&quot;/g, '"'));
var costs = JSON.parse("{{$costsByDaysStatistics}}".replace(/&quot;/g, '"'));
            var actionMsg = "{{__('backend.List action message', ['action' => '%action%', 'item' => '%item%'])}}";

    $('body').on('click', '.dev-list-ajax-action', function () {
            var clickedObj = $(this);
            showConfirmationBox(actionMsg.replace('%action%', clickedObj.attr('title')).replace('%item%', clickedObj.attr('data-name')), function () {
                $.ajax({
                    url: clickedObj.attr('data-href'),
                    success: function (resp) {
                        clickedObj.closest('.mt-action').remove();
                        showNotification(resp.status, resp.message);
                    }
                });
            }, $(this).attr('title'));
        });

    $('#confirmationModal .dev-confirm').click(function () {
            $('#confirmationModal').modal('hide');
            callbackFunction();
        });
</script>


@endsection

@section('content')

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue"
                                                          href="#">
            <div class="visual"> <i class="fa fa-comments"></i> </div>
            <div class="details">
                <div class="number"><span data-counter="counterup" data-value="{{Assets::countTotalOrders()}}">0</span></div>
                <div class="desc"> طلبات توثيق</div>
            </div>
        </a> </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 red"
                                                          href="#">
            <div class="visual"> <i class="fa fa-bar-chart-o"></i> </div>
            <div class="details">
                <div class="number"><span data-counter="counterup" data-value="{{Assets::countTotalOrdersCost()}}">0</span></div>
                <div class="desc"> العمليات النقديه</div>
            </div>
        </a> </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 green"
                                                          href="#">
            <div class="visual"> <i class="fa fa-shopping-cart"></i> </div>
            <div class="details">
                <div class="number"> <span data-counter="counterup" data-value="{{Assets::countTotalClients()}}">0</span>
                </div>
                <div class="desc"> مستخدم</div>
            </div>
        </a> </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 purple"
                                                          href="#">
            <div class="visual"> <i class="fa fa-globe"></i> </div>
            <div class="details">
                <div class="number">
                <span data-counter="counterup" data-value="{{Assets::countTotalLawyers()}}"></span>
                </div>
                <div class="desc"> موثق</div>
            </div>
        </a> </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12"> <br>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption"><em class="icon-bar-chart font-dark hide"></em> <span class="caption-subject font-dark bold uppercase">طلبات توثيق</span> <span class="caption-helper">احصائية اسبوعية...</span></div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <!-- <label class="btn red btn-outline btn-circle btn-sm active">
                            <input name="options" class="toggle" id="option1" type="radio">
                            جديد</label> -->
                        <!-- <label class="btn red btn-outline btn-circle btn-sm"> <input
                                name="options"
                                class="toggle"
                                id="option2"
                                type="radio">
                            مغلق</label> -->
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div id="site_statistics_loading"> <img src="{{asset('backend-assets/global/img/loading.gif')}}"
                                                        alt="loading">
                </div>
                <div id="site_statistics_content" class="display-none">
                    <div id="site_statistics" class="chart"> </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET--> </div>
    <div class="col-lg-6 col-xs-12 col-sm-12"> <br>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption"><em class="icon-share font-red-sunglo hide"></em> <span class="caption-subject font-dark bold uppercase">الدخل</span> <span class="caption-helper">شهرياً...</span></div>
                <div class="actions">
                    <!-- <div class="btn-group"><a class="btn dark btn-outline btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> المدى <span class="fa fa-angle-down"> </span></a>
                        <ul class="dropdown-menu pull-right">
                            <li> <a href="javascript:;"> Q1 2014 <span class="label label-sm label-default">
                                        past </span> </a> </li>
                            <li> <a href="javascript:;"> Q2 2014 <span class="label label-sm label-default">
                                        past </span> </a> </li>
                            <li class="active"> <a href="javascript:;"> Q3 2014 <span
                                        class="label label-sm label-success">
                                        current </span> </a> </li>
                            <li> <a href="javascript:;"> Q4 2014 <span class="label label-sm label-warning">
                                        upcoming </span> </a> </li>
                        </ul>
                    </div> -->
                </div>
            </div>
            <div class="portlet-body">
                <div id="site_activities_loading"> <img src="{{asset('backend-assets/global/img/loading.gif')}}"
                                                        alt="loading">
                </div>
                <div id="site_activities_content" class="display-none">
                    <div id="site_activities" style="height: 228px;"> </div>
                </div>
                <div style="margin: 20px 0 10px 30px">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 text-stat"><span class="label label-sm label-success"> وكالات </span>
                            <h3>{{$stat1 = Assets::countTotalAuthorizationCost()}} ريال</h3>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 text-stat"><span class="label label-sm label-info"> عقود </span>
                            <h3>{{$stat2 = Assets::countTotalContractCost()}} ريال</h3>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 text-stat"><span class="label label-sm label-danger"> نكاح </span>
                            <h3>{{$stat3 = Assets::countTotalMarriageContractsCost()}} ريال</h3>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 text-stat"><span class="label label-sm label-warning"> إجمالي </span>
                            <h3>{{$stat1 + $stat2 + $stat3}} ريال</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET--> </div>
</div>
<div class="row">

    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption"><em class=" icon-social-twitter font-dark hide"></em> <span class="caption-subject font-dark bold uppercase">موثقين بانتظار الموافقة</span></div>
                
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_pending">
                        <!-- BEGIN: Actions -->
                        <div class="mt-actions">
                            @if(!count($lawyers))
                            <div class="mt-action">
                                <p>ﻻ يوجد طلبات</p>
                            </div>
                            @endif
                            @foreach($lawyers as $lawyer)
                            <div class="mt-action">
                                <div class="mt-action-img"> 
                                    <img class="img-responsive" src="{{asset($lawyer->image ? 'uploads/'.$lawyer->image : 'backend-assets/pages/media/profile/profile.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> <i class="icon-bell"></i>
                                            </div>
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author">{{$lawyer->name ? $lawyer->name : '--'}}</span>
                                                <p class="mt-action-desc">{{$lawyer->phone}}</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-dot bg-green"></span>
                                            <span class="mt=action-time">{{date('Y-m-d', strtotime($lawyer->created_at))}}</span> 
                                        </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group "> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm dev-list-ajax-action" data-name="({{$lawyer->name}})" title="{{__('backend.Activate')}}" data-href="{{route('backend.lawyer.toggleActive', ['id' => $lawyer->id, 'active' => 1])}}"> اعتماد</button>
                                                <!-- <button type="button" class="btn btn-outline red btn-sm">رفض</button> -->
                                            </div>
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

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption"><em class="icon-bubble font-dark hide"></em> <span class="caption-subject font-hide bold uppercase">مستخدمون جدد</span></div>
        
    </div>
    <div class="portlet-body">
        <div class="row">
            @foreach(Assets::latestThreeClients() as $cleint)
            <div class="col-md-4">
                <!--begin: widget 1-1 -->
                <div class="mt-widget-1">
                    <div class="mt-img"> <img src="{{asset($cleint->image ? 'uploads/'.$cleint->image : 'backend-assets/pages/media/profile/profile.jpg')}}" style="width: 80px; height: 80px"> </div>
                    <div class="mt-body">
                        <h3 class="mt-username">{{$cleint->name ? $cleint->name : '--'}}</h3>
                        <p class="mt-user-title"> {{$cleint->phone ? $cleint->phone : '--'}} </p>
                        <div class="mt-stats"> </div>
                    </div>
                </div>
                <!--end: widget 1-1 -->
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12"></div>
</div>

@endsection()

