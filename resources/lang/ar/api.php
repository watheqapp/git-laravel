<?php

/**
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Api Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the API's controllers. 
    |
    */
    
    // User API'S
    'Deactivated Account' => 'This account is disabled',
    'Access token and access token secret are required' => 'Access token and access token secret are required.',
    
   'success' => 'تمت العملية بنجاح',
    
    // Logging order process
    'order_created_log' => 'تم إضافة طلب جديد  بواسطة المستخدم :user',
    'order_accepted_log' => 'تم قبول الطلب  بواسطة الموثق :lawyer الذى يقع فى الاحداثيات :direction',
    'order_notify_lawyer_log' => 'تم اشعار عدد محامون :lawyersCount فى خلال المساحة :distance كيلو متر وهم :lawyers',
    'order_notify_client_accept_log' => 'تم اشعار المستخدم :client بقبول الطلب من قبل الموثق :lawyer   ',
    'order_notify_client_close_log' => 'تم اشعار المستخدم :client بغلق الطلب من قبل الموثق :lawyer   ',
    'order_notify_client_not_accept_log' => 'تم اشعار المستخدم :client بنفاذ وقت قبول المحامين لطلبه  ',
    'force_select_lawyer_log' => 'تم اختيار الموثق :lawyer من قبل المستخدم',
    'notify_lawyer_force_select_log' => 'تم اشعار الموثق :lawyer باختياره يدويا من قبل المستخدم',
    'order_close_log' => 'تم غلق الطلب من قبل الموثق :lawyer ',
    'No log for this order request' => 'ﻻ توجد نتائج لهذا الطلب',
    'createdOrder' => 'إضافة الطلب',
    'acceptOrder' => 'قبول الطلب',
    'closeOrder' => 'غلق الطلب',
    'notifyLawyer' => 'اشعار المحامون',
    'notifyClientAccept' => 'اشعار بقبول الطلب',
    'notifyClientClose' => 'اشعار بغلق الطلب',
    'notifyClientNotAccept' => 'اشعار بنفاذ مدة قبول الطلب',
    'forceSelectLawyer' => 'اختيار محامى بشكل يدوى',
    'notifyForceSelectLawyer' => 'اشعار اختيار محامى',
    'Order ID' => 'رقم الطلب',
    'Order process logging' => 'متابعة حركة الطلبات',
    'Log type' => 'نوع الحركة',
    'Message' => 'الرسالة',
    'Check Log' => 'فحص الطلب',
    'CreateAt' => 'وقت التنفيذ',

    // Notifications
    // For Lawyer - In case if new request
 	'New order request title' => 'طلب جديد',
    'New order request content' => 'طلب توثيق جديد بجوارك ينتظر الموافقه',
    // For Lawyer - In case of client select lawyer for his request
    'Assigned order request title' => 'مهمة جديدة',
    'Assigned order request content' => 'لديك مهمة توثيق مسندة إليك, اضغط للاطلاع على التفاصيل',
    // For Client - In case of no lawyer accept his request
    'No Laywer Accept order title' => 'اختر موثقك',
    'No Laywer Accept order content' => 'لم يرد أحد على طلبك, يرجى اختيار موثقاً آخر',
    // For Client - In case of lawyer accept his request 
    'Laywer Accept order title' => 'تمت الموافقة على طلبك',
    'Laywer Accept order content' => 'اضغط للتحدث مباشرة إلى موثقك المختار',
    // For Client - In case of lawyer accept his request
    'Laywer Close order title' => 'تم انهاء طلبك',
    'Laywer Close order content' => ', شكرا لاستخدامك وثق ,اضغط هنا لتقييم خدمة موثقك',

    
    
    
    ];
