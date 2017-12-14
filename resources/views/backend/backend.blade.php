@extends('backend.layouts.app')



@section('content')
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue"
                                                          href="#">
            <div class="visual"> <i class="fa fa-comments"></i> </div>
            <div class="details">
                <div class="number"><span data-counter="counterup" data-value="1349">330</span></div>
                <div class="desc"> طلبات توثيق</div>
            </div>
        </a> </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 red"
                                                          href="#">
            <div class="visual"> <i class="fa fa-bar-chart-o"></i> </div>
            <div class="details">
                <div class="number"><span data-counter="counterup" data-value="12,5">12500</span></div>
                <div class="desc"> العمليات النقديه</div>
            </div>
        </a> </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 green"
                                                          href="#">
            <div class="visual"> <i class="fa fa-shopping-cart"></i> </div>
            <div class="details">
                <div class="number"> <span data-counter="counterup" data-value="549">0</span>
                </div>
                <div class="desc"> مستخدم</div>
            </div>
        </a> </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 purple"
                                                          href="#">
            <div class="visual"> <i class="fa fa-globe"></i> </div>
            <div class="details">
                <div class="number">98</div>
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
                        <label class="btn red btn-outline btn-circle btn-sm active">
                            <input name="options" class="toggle" id="option1" type="radio">
                            جديد</label>
                        <label class="btn red btn-outline btn-circle btn-sm"> <input
                                name="options"
                                class="toggle"
                                id="option2"
                                type="radio">
                            مغلق</label>
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
                    <div class="btn-group"><a class="btn dark btn-outline btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> المدى <span class="fa fa-angle-down"> </span></a>
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
                    </div>
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
                        <div class="col-md-3 col-sm-3 col-xs-6 text-stat"><span class="label label-sm label-success"> وكالات: </span>
                            <h3>$13,234</h3>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 text-stat"><span class="label label-sm label-info"> عقود: </span>
                            <h3>$134,900</h3>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 text-stat"><span class="label label-sm label-danger"> نكاح: </span>
                            <h3>$1,134</h3>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 text-stat"><span class="label label-sm label-warning"> إجمالي: </span>
                            <h3>235090</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET--> </div>
</div>
<div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption"><em class="icon-bubbles font-dark hide"></em> <span class="caption-subject font-dark bold uppercase">محاورات مع الموثقين</span></div>
                <ul class="nav nav-tabs">
                    <li class="active"> <a href="#portlet_comments_1" data-toggle="tab"> مفتوحة</a></li>
                    <li> <a href="#portlet_comments_2" data-toggle="tab"> منتهية</a></li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_comments_1">
                        <!-- BEGIN: Comments -->
                        <div class="mt-comments">
                            <div class="mt-comment">
                                <div class="mt-comment-img"> <img src="{{asset('backend-assets/pages/media/users/avatar1.jpg')}}">
                                </div>
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info"><span class="mt-comment-author">أحمد عبدالله</span> <span class="mt-comment-date">26
                                            Feb, 10:30AM</span></div>
                                    <div class="mt-comment-text">اخر رسالة في الطلب تظهر هنا وللتفاصيل اضغط هنا </div>
                                    <div class="mt-comment-details"><span class="mt-comment-status mt-comment-status-pending">موثق : عبدالله السعيد</span>
                                        <ul class="mt-comment-actions">
                                            <li> <a href="#">Quick Edit</a> </li>
                                            <li> <a href="#">View</a> </li>
                                            <li> <a href="#">Delete</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-comment">
                                <div class="mt-comment-img"> <img src="{{asset('backend-assets/pages/media/users/avatar6.jpg')}}">
                                </div>
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info"><span class="mt-comment-author">ليلي</span> <span class="mt-comment-date">12
                                            Feb, 08:30AM</span></div>
                                    <div class="mt-comment-text">اخر رسالة في الطلب تظهر هنا وللتفاصيل اضغط هنا </div>
                                    <div class="mt-comment-details"><span class="mt-comment-status mt-comment-status-rejected">مأذون : عبدالحكيم محمد</span>
                                        <ul class="mt-comment-actions">
                                            <li> <a href="#">Quick Edit</a> </li>
                                            <li> <a href="#">View</a> </li>
                                            <li> <a href="#">Delete</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-comment">
                                <div class="mt-comment-img"> <img src="{{asset('backend-assets/pages/media/users/avatar8.jpg')}}">
                                </div>
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info"><span class="mt-comment-author">أمة العليم</span> <span class="mt-comment-date">19
                                            Dec,09:50 AM</span></div>
                                    <div class="mt-comment-text">اخر رسالة في الطلب تظهر هنا وللتفاصيل اضغط هنا </div>
                                    <div class="mt-comment-details"><span class="mt-comment-status mt-comment-status-pending">موثق : أحمد العليان</span>
                                        <ul class="mt-comment-actions">
                                            <li> <a href="#">Quick Edit</a> </li>
                                            <li> <a href="#">View</a> </li>
                                            <li> <a href="#">Delete</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-comment">
                                <div class="mt-comment-img"> <img src="{{asset('backend-assets/pages/media/users/avatar4.jpg')}}">
                                </div>
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info"><span class="mt-comment-author">سلطان</span> <span class="mt-comment-date">10
                                            Dec, 09:20 AM</span></div>
                                    <div class="mt-comment-text">اخر رسالة في الطلب تظهر هنا وللتفاصيل اضغط هنا </div>
                                    <div class="mt-comment-details"><span class="mt-comment-status mt-comment-status-rejected">مأثون : سعيد الخالدي</span>
                                        <ul class="mt-comment-actions">
                                            <li> <a href="#">Quick Edit</a> </li>
                                            <li> <a href="#">View</a> </li>
                                            <li> <a href="#">Delete</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Comments --> </div>
                    <div class="tab-pane" id="portlet_comments_2">
                        <!-- BEGIN: Comments -->
                        <div class="mt-comments">
                            <div class="mt-comment">
                                <div class="mt-comment-img"> <img src="{{asset('backend-assets/pages/media/users/avatar4.jpg')}}">
                                </div>
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info"> <span class="mt-comment-author">Michael
                                            Baker</span> <span class="mt-comment-date">26
                                            Feb, 10:30AM</span> </div>
                                    <div class="mt-comment-text"> Lorem Ipsum is simply
                                        dummy text of the printing and typesetting
                                        industry. Lorem Ipsum has been the industry's
                                        standard dummy. </div>
                                    <div class="mt-comment-details"> <span class="mt-comment-status mt-comment-status-approved">Approved</span>
                                        <ul class="mt-comment-actions">
                                            <li> <a href="#">Quick Edit</a> </li>
                                            <li> <a href="#">View</a> </li>
                                            <li> <a href="#">Delete</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-comment">
                                <div class="mt-comment-img"> <img src="{{asset('backend-assets/pages/media/users/avatar8.jpg')}}">
                                </div>
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info"> <span class="mt-comment-author">Larisa
                                            Maskalyova</span> <span class="mt-comment-date">12
                                            Feb, 08:30AM</span> </div>
                                    <div class="mt-comment-text"> It is a long
                                        established fact that a reader will be distracted
                                        by. </div>
                                    <div class="mt-comment-details"> <span class="mt-comment-status mt-comment-status-approved">Approved</span>
                                        <ul class="mt-comment-actions">
                                            <li> <a href="#">Quick Edit</a> </li>
                                            <li> <a href="#">View</a> </li>
                                            <li> <a href="#">Delete</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-comment">
                                <div class="mt-comment-img"> <img src="{{asset('backend-assets/pages/media/users/avatar6.jpg')}}">
                                </div>
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info"> <span class="mt-comment-author">Natasha
                                            Kim</span> <span class="mt-comment-date">19
                                            Dec,09:50 AM</span> </div>
                                    <div class="mt-comment-text"> The generated Lorem
                                        Ipsum is therefore always free from repetition,
                                        injected humour, or non-characteristic words etc.
                                    </div>
                                    <div class="mt-comment-details"> <span class="mt-comment-status mt-comment-status-approved">Approved</span>
                                        <ul class="mt-comment-actions">
                                            <li> <a href="#">Quick Edit</a> </li>
                                            <li> <a href="#">View</a> </li>
                                            <li> <a href="#">Delete</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-comment">
                                <div class="mt-comment-img"> <img src="{{asset('backend-assets/pages/media/users/avatar1.jpg')}}">
                                </div>
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info"> <span class="mt-comment-author">Sebastian
                                            Davidson</span> <span class="mt-comment-date">10
                                            Dec, 09:20 AM</span> </div>
                                    <div class="mt-comment-text"> The standard chunk of
                                        Lorem Ipsum used since the 1500s </div>
                                    <div class="mt-comment-details"> <span class="mt-comment-status mt-comment-status-approved">Approved</span>
                                        <ul class="mt-comment-actions">
                                            <li> <a href="#">Quick Edit</a> </li>
                                            <li> <a href="#">View</a> </li>
                                            <li> <a href="#">Delete</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Comments --> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption"><em class=" icon-social-twitter font-dark hide"></em> <span class="caption-subject font-dark bold uppercase">بانتظار الموافقة</span></div>
                <ul class="nav nav-tabs">
                    <li class="active"> <a href="#tab_actions_pending" data-toggle="tab"> قائمة</a></li>
                    <li> <a href="#tab_actions_completed" data-toggle="tab"> مقبولة</a></li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_pending">
                        <!-- BEGIN: Actions -->
                        <div class="mt-actions">
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar10.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> <i class="icon-magnet"></i>
                                            </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ١</span>
                                                <p class="mt-action-desc">0538493</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-green"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm"> اعتماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar3.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> <i class=" icon-bubbles"></i>
                                            </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ١</span>
                                                <p class="mt-action-desc">0538493</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-red"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm">اعتماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar2.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> <i class="icon-call-in"></i>
                                            </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ١</span>
                                                <p class="mt-action-desc">0538493</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-green"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm">اعتماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar7.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> <i class=" icon-bell"></i>
                                            </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ١</span>
                                                <p class="mt-action-desc">0538493</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-red"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm">اعتماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar8.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> <i class="icon-magnet"></i>
                                            </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ١ </span>
                                                <p class="mt-action-desc">0538493</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-green"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm">اعتماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar9.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> <i class="icon-magnet"></i>
                                            </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ١</span>
                                                <p class="mt-action-desc">0538493</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-green"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm">اعتماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Actions --> </div>
                    <div class="tab-pane" id="tab_actions_completed">
                        <!-- BEGIN:Completed-->
                        <div class="mt-actions">
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar1.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ١</span>
                                                <p class="mt-action-desc">اضغط لمشاهدة اوراق الموثق او المحامي</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-red"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm">اعتماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar8.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ٢</span>
                                                <p class="mt-action-desc">اضغط لمشاهدة اوراق الموثق او المحامي</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-green"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm">اعتماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar5.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ٣</span>
                                                <p class="mt-action-desc">اضغط لمشاهدة اوراق الموثق او المحامي</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-red"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm">اعتاماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img"> <img src="{{asset('backend-assets/pages/media/users/avatar2.jpg')}}">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-icon "> </div>
                                            <div class="mt-action-details "><span class="mt-action-author">موثق ٤</span>
                                                <p class="mt-action-desc">اضغط لمشاهدة اوراق الموثق او المحامي</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime "> <span class="mt-action-date">3
                                                jun</span> <span class="mt-action-dot bg-green"></span>
                                            <span class="mt=action-time">9:30-13:00</span> </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group btn-group-circle"> <button
                                                    type="button"
                                                    class="btn btn-outline green btn-sm">اعتماد</button>
                                                <button type="button" class="btn btn-outline red btn-sm">رفض</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Completed --> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption"><span class="caption-subject font-dark bold uppercase">نشاطات قريبة</span></div>
                <div class="actions">
                    <div class="btn-group"><a class="btn btn-sm blue btn-outline btn-circle" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> تصفية <em class="fa fa-angle-down"></em></a>
                        <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                            <label class="mt-checkbox mt-checkbox-outline"> <input
                                    type="checkbox">
                                Finance <span></span> </label> <label class="mt-checkbox mt-checkbox-outline">
                                <input checked="checked" type="checkbox"> Membership <span></span>
                            </label> <label class="mt-checkbox mt-checkbox-outline">
                                <input type="checkbox"> Customer Support <span></span>
                            </label> <label class="mt-checkbox mt-checkbox-outline">
                                <input checked="checked" type="checkbox"> HR <span></span>
                            </label> <label class="mt-checkbox mt-checkbox-outline">
                                <input type="checkbox"> System <span></span> </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="scroller" style="height: 300px;" data-always-visible="1"
                     data-rail-visible="0">
                    <ul class="feeds">
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-info"> <i class="fa fa-check"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc">محامي ١ انهى طلب رقم ٣٠٣ بنجاح<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> Just now </div>
                            </div>
                        </li>
                        <li> <a href="javascript:;">
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success"> <i class="fa fa-bar-chart-o"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> ماذون احمد سجل عضوية جديدة</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 20 mins </div>
                                </div>
                            </a> </li>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-danger"> <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc"> تم تغيير اسعار توثيق النكاح</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> 24 mins </div>
                            </div>
                        </li>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-info"> <i class="fa fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc">طلب رقم ٣٤٥ لم يتم تحديثه منذ شهر<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> 30 mins </div>
                            </div>
                        </li>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-success"> <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc"> مستخدم علي عماد قام بدفع ٦٥ ريال للموثق ٣٣٣</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> 24 mins </div>
                            </div>
                        </li>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-default"> <i class="fa fa-bell-o"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc">يجب تحصيل الاشتراكات من محامي النكاح اليوم<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> 2 hours </div>
                            </div>
                        </li>
                        <li> <a href="javascript:;">
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default"> <i class="fa fa-briefcase"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> محامي سالم قام بتقييم المستخدم علي بنجمة واحده</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 20 mins </div>
                                </div>
                            </a> </li>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-info"> <i class="fa fa-check"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc">تم ارسال تنبيه بتحديث جديد<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> Just now </div>
                            </div>
                        </li>
                        <li> <a href="javascript:;">
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-danger"> <i class="fa fa-bar-chart-o"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> Finance Report for year 2013
                                                has been released. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 20 mins </div>
                                </div>
                            </a> </li>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-default"> <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc"> You have 5 pending membership
                                            that requires a quick review. </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> 24 mins </div>
                            </div>
                        </li>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-info"> <i class="fa fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc"> New order received with <span
                                                class="label label-sm label-success">
                                                Reference Number: DR23923 </span> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> 30 mins </div>
                            </div>
                        </li>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-success"> <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc"> You have 5 pending membership
                                            that requires a quick review. </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> 24 mins </div>
                            </div>
                        </li>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-warning"> <i class="fa fa-bell-o"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc"> Web server hardware needs to be
                                            upgraded. <span class="label label-sm label-default ">
                                                Overdue </span> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date"> 2 hours </div>
                            </div>
                        </li>
                        <li> <a href="javascript:;">
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info"> <i class="fa fa-briefcase"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> IPO Report for year 2013 has
                                                been released. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 20 mins </div>
                                </div>
                            </a> </li>
                    </ul>
                </div>
                <div class="scroller-footer">
                    <div class="btn-arrow-link pull-right"><a href="javascript:;">جميع النشاطات</a> <em class="icon-arrow-right"></em></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light tasks-widget bordered">
            <div class="portlet-title">
                <div class="caption"><em class="icon-share font-dark hide"></em> <span class="caption-subject font-dark bold uppercase">طلبات توثيق</span> <span class="caption-helper">متابعة الطلبات...</span></div>
                <div class="actions">
                    <div class="btn-group">
                        <ul class="dropdown-menu pull-right">
                            <li> <a href="javascript:;"> All Project </a> </li>
                            <li class="divider"> </li>
                            <li> <a href="javascript:;"> AirAsia </a> </li>
                            <li> <a href="javascript:;"> Cruise </a> </li>
                            <li> <a href="javascript:;"> HSBC </a> </li>
                            <li class="divider"> </li>
                            <li> <a href="javascript:;"> Pending <span class="badge badge-danger">
                                        4 </span> </a> </li>
                            <li> <a href="javascript:;"> Completed <span class="badge badge-success">
                                        12 </span> </a> </li>
                            <li> <a href="javascript:;"> Overdue <span class="badge badge-warning">
                                        9 </span> </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="task-content">
                    <div class="scroller" style="height: 312px;" data-always-visible="1"
                         data-rail-visible1="1">
                        <!-- START TASK LIST -->
                        <ul class="task-list">
                            <li>
                                <div class="task-checkbox"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input class="checkboxes" value="1" type="checkbox">
                                        <span></span> </label> </div>
                                <div class="task-title">فلان طلب من الموثق الفلاني<br>
                                </div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group"> <a class="btn btn-sm default"
                                                                               href="javascript:;"
                                                                               data-toggle="dropdown"
                                                                               data-hover="dropdown"
                                                                               data-close-others="true">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li> <a href="javascript:;"> <i class="fa fa-check"></i>
                                                    Complete </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-pencil"></i>
                                                    Edit </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i>
                                                    Cancel </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="task-checkbox"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input class="checkboxes" value="1" type="checkbox">
                                        <span></span> </label> </div>
                                <div class="task-title">فلان طلب من الموثق الفلاني<br>
                                </div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group"> <a class="btn btn-sm default"
                                                                               href="javascript:;"
                                                                               data-toggle="dropdown"
                                                                               data-hover="dropdown"
                                                                               data-close-others="true">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li> <a href="javascript:;"> <i class="fa fa-check"></i>
                                                    Complete </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-pencil"></i>
                                                    Edit </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i>
                                                    Cancel </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="task-checkbox"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input class="checkboxes" value="1" type="checkbox">
                                        <span></span> </label> </div>
                                <div class="task-title"><span class="task-title-sp">فلان طلب من الموثق الفلاني </span> <span class="label label-sm label-success">عقد</span><span class="task-bell"> <em class="fa fa-bell-o"></em></span></div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group"> <a class="btn btn-sm default"
                                                                               href="javascript:;"
                                                                               data-toggle="dropdown"
                                                                               data-hover="dropdown"
                                                                               data-close-others="true">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li> <a href="javascript:;"> <i class="fa fa-check"></i>
                                                    Complete </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-pencil"></i>
                                                    Edit </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i>
                                                    Cancel </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="task-checkbox"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input class="checkboxes" value="1" type="checkbox">
                                        <span></span> </label> </div>
                                <div class="task-title"><span class="task-title-sp"> فلان طلب من الموثق الفلاني عقد </span> <span class="label label-sm label-warning">نكاح</span></div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group"> <a class="btn btn-sm default"
                                                                               href="javascript:;"
                                                                               data-toggle="dropdown"
                                                                               data-hover="dropdown"
                                                                               data-close-others="true">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li> <a href="javascript:;"> <i class="fa fa-check"></i>
                                                    Complete </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-pencil"></i>
                                                    Edit </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i>
                                                    Cancel </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="task-checkbox"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input class="checkboxes" value="1" type="checkbox">
                                        <span></span> </label> </div>
                                <div class="task-title"><span class="task-title-sp"> فلان طلب من الموثق الفلاني عقد </span> <span class="label label-sm label-info">وكالة</span></div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group"> <a class="btn btn-sm default"
                                                                               href="javascript:;"
                                                                               data-toggle="dropdown"
                                                                               data-hover="dropdown"
                                                                               data-close-others="true">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li> <a href="javascript:;"> <i class="fa fa-check"></i>
                                                    Complete </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-pencil"></i>
                                                    Edit </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i>
                                                    Cancel </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="task-checkbox"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input class="checkboxes" value="1" type="checkbox">
                                        <span></span> </label> </div>
                                <div class="task-title">فلان طلب من الموثق الفلاني عقد <br>
                                </div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group"> <a class="btn btn-sm default"
                                                                               href="javascript:;"
                                                                               data-toggle="dropdown"
                                                                               data-hover="dropdown"
                                                                               data-close-others="true">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li> <a href="javascript:;"> <i class="fa fa-check"></i>
                                                    Complete </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-pencil"></i>
                                                    Edit </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i>
                                                    Cancel </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="task-checkbox"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input class="checkboxes" value="1" type="checkbox">
                                        <span></span> </label> </div>
                                <div class="task-title">فلان طلب من الموثق الفلاني عقد <br>
                                </div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group dropup"> <a class="btn btn-sm default"
                                                                                      href="javascript:;"
                                                                                      data-toggle="dropdown"
                                                                                      data-hover="dropdown"
                                                                                      data-close-others="true">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li> <a href="javascript:;"> <i class="fa fa-check"></i>
                                                    Complete </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-pencil"></i>
                                                    Edit </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i>
                                                    Cancel </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="task-checkbox"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input class="checkboxes" value="1" type="checkbox">
                                        <span></span> </label> </div>
                                <div class="task-title">فلان طلب من الموثق الفلاني عقد شركة<br>
                                </div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group dropup"> <a class="btn btn-sm default"
                                                                                      href="javascript:;"
                                                                                      data-toggle="dropdown"
                                                                                      data-hover="dropdown"
                                                                                      data-close-others="true">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li> <a href="javascript:;"> <i class="fa fa-check"></i>
                                                    Complete </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-pencil"></i>
                                                    Edit </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i>
                                                    Cancel </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="last-line">
                                <div class="task-checkbox"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input class="checkboxes" value="1" type="checkbox">
                                        <span></span> </label> </div>
                                <div class="task-title"> <span class="task-title-sp">
                                        KeenThemes Investment Discussion </span> <span class="label label-sm label-warning">KeenThemes
                                    </span> </div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group dropup"> <a class="btn btn-sm default"
                                                                                      href="javascript:;"
                                                                                      data-toggle="dropdown"
                                                                                      data-hover="dropdown"
                                                                                      data-close-others="true">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li> <a href="javascript:;"> <i class="fa fa-check"></i>
                                                    Complete </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-pencil"></i>
                                                    Edit </a> </li>
                                            <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i>
                                                    Cancel </a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- END START TASK LIST --> </div>
                </div>
                <div class="task-footer">
                    <div class="btn-arrow-link pull-right"><a href="javascript:;"> جميع الطلبات</a> <em class="icon-arrow-right"></em></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption"><em class="icon-bubble font-dark hide"></em> <span class="caption-subject font-hide bold uppercase">مستخدمون جدد</span></div>
        <div class="actions">
            <div class="btn-group">
                <ul class="dropdown-menu pull-right">
                    <li> <a href="javascript:;"> Option 1</a></li>
                    <li class="divider"> </li>
                    <li> <a href="javascript:;">Option 2</a></li>
                    <li> <a href="javascript:;">Option 3</a></li>
                    <li> <a href="javascript:;">Option 4</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-4">
                <!--begin: widget 1-1 -->
                <div class="mt-widget-1">
                    <div class="mt-icon"> <a href="#"> <i class="icon-plus"></i> </a></div>
                    <div class="mt-img"> <img src="{{asset('backend-assets/pages/media/users/avatar80_8.jpg')}}"> </div>
                    <div class="mt-body">
                        <h3 class="mt-username">علي الصالحي</h3>
                        <p class="mt-user-title"> 05538383 </p>
                        <div class="mt-stats"> </div>
                    </div>
                </div>
                <!--end: widget 1-1 -->
            </div>
            <div class="col-md-4">
                <!--begin: widget 1-2 -->
                <div class="mt-widget-1">
                    <div class="mt-icon"> <a href="#"> <i class="icon-plus"></i> </a></div>
                    <div class="mt-img"> <img src="{{asset('backend-assets/pages/media/users/avatar80_7.jpg')}}"> </div>
                    <div class="mt-body">
                        <h3 class="mt-username">عماد المسعودي</h3>
                        <p class="mt-user-title"> 05538383 </p>
                        <div class="mt-stats"> </div>
                    </div>
                </div>
                <!--end: widget 1-2 -->
            </div>
            <div class="col-md-4">
                <!--begin: widget 1-3 -->
                <div class="mt-widget-1">
                    <div class="mt-icon"> <a href="#"> <i class="icon-plus"></i> </a></div>
                    <div class="mt-img"> <img src="{{asset('backend-assets/pages/media/users/avatar80_6.jpg')}}"> </div>
                    <div class="mt-body">
                        <h3 class="mt-username">جابر مسعود</h3>
                        <p class="mt-user-title"> 05538383</p>
                        <div class="mt-stats"> </div>
                    </div>
                </div>
                <!--end: widget 1-3 -->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12"></div>
</div>

@endsection()

