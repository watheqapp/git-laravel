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
    'order_created_log' => 'تم إضافة طلب جديد بتوقيت :date بواسطة المستخدم :user',
    'order_accepted_log' => 'تم قبول الطلب بتوقيت :date بواسطة المحامى :lawyer الذى يقع فى الاحداثيات :direction',
    'order_notify_lawyer_log' => 'تم اشعار عدد محامون :lawyersCount فى الاحداثيات :distance  بتوقيت :date وهم :lawyers',
    'order_notify_client_accept_log' => 'تم اشعار المستخدم :client بقبول الطلب من قبل المحامى :lawyer  بتوقيت :date ',
    'order_notify_client_not_accept_log' => 'تم اشعار المستخدم :client بنفاذ وقت قبول المحامين لطلبه بتوقيت :date ',
    'No log for this order request' => 'ﻻ توجد نتائج لهذا الطلب',
    'createdOrder' => 'إضافة الطلب',
    'acceptOrder' => 'قبول الطلب',
    'notifyLawyer' => 'اشعار المحامون',
    'notifyClientAccept' => 'اشعار بقبول الطلب',
    'notifyClientNotAccept' => 'اشعار بنفاذ مدة قبول الطلب',
    'Order ID' => 'رقم الطلب',
    'Order process logging' => 'متابعة حركة الطلبات',
    'Log type' => 'نوع الحركة',
    'Message' => 'الرسالة',
    'Check Log' => 'فحص الطلب'
    
    
    ];
