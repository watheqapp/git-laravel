<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="apple-itunes-app" content="app-id=myAppStoreID, affiliate-data=myAffiliateData, app-argument=myURL">
    
    <meta name="apple-itunes-app" content="app-id=502838820">
    <meta name="google-play-app" content="app-id=ru.hh.android">
    <link rel="stylesheet" href="{{asset('frontend/css/smart-app-banner.css')}}" type="text/css" media="screen">
    <link rel="apple-touch-icon" href="{{asset('frontend/images/ios.png"')}}>
    <link rel="android-touch-icon" href="{{asset('frontend/images/android.png"')}} />
    
    <link rel="shortcut icon" href="{{asset('frontend/images/fivicon.png')}}">

    <title>وثّق - اطلب موثق أو مأذون شرعي</title>
    
    
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/js/script.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.fullPage.min.js')}}"></script>
    

    
    <!-- Bootstrap core CSS -->
    
    <link href="{{asset('frontend/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/bootstrap-rtl.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/bootstrap.css.map')}}" rel="stylesheet">
    <!-- Custom styles for this template -->
    
    <link href="{{asset('frontend/css/font-awesome.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('frontend/css/ihover.css')}}" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
  <![endif]-->
  <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('frontend/css/media.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('frontend/css/SpryTabbedPanels.css')}}" rel="stylesheet" type="text/css">
</head>
<!-------------------header------------------>

<body data-spy="scroll" data-target=".navbar-default .modal-open" id="home">


 <script src="{{asset('frontend/js/smart-app-banner.js')}}"></script>
 <script type="text/javascript">
  new SmartBanner({
          daysHidden: 15,   // days to hide banner after close button is clicked (defaults to 15)
          daysReminder: 90, // days to hide banner after "VIEW" button is clicked (defaults to 90)
          appStoreLanguage: 'ar', // language code for the App Store (defaults to user's browser language)
          title: 'وثق',
          author: '',
          button: 'تحميل',
          store: {
              ios: 'On the App Store',
              android: 'In Google Play',
              windows: 'In Windows store'
          },
          price: {
              ios: 'FREE',
              android: 'FREE',
              windows: 'FREE'
          }
          // , theme: '' // put platform type ('ios', 'android', etc.) here to force single theme on all device
          // , icon: '' // full path to icon image if not using website icon image
          // , force: 'ios' // Uncomment for platform emulation
      });
  </script>

  <div id="fullpage" class="fullpage-wrapper">

    <section class="vertical-scrolling fp-section fp-table background_yallow " data-anchor="firstSection" >
      
      <div class="container text-center">
        <div class="col-sm-9 background_yallow text-center padding_top_20 white right_side paddinf_small">
            <div class="logo"><img src="{{asset('frontend/images/logo2.png')}}"></div>
            
            <p style="color: #403737;"> اطلب موثقاً أو مأذوناً ليصلك في الوقت والمكان الذي تحدده.<br>
                أو احجز موعداً في الوقت المناسب لك في اقرب مكتب توثيق أو مأذون. </p>
                <h2 style="color: #403737;" class="hideinsmall">  وثق أسرع</h2>
            <div class="download margin_top_50 iconsmall ">
                <a href="http://onelink.to/wathiq"> <img src="{{asset('frontend/images/all.png')}}"> </a>
                <!--<a href=""> <img src="{{asset('frontend/images/ios.png')}}"> </a>-->
            </div>
        </div>
        
        <div class="col-sm-3 background_yallow text-center ">
        
            <div class="col-sm-12 imagesmall">
                <img src="{{asset('frontend/images/ios4.png')}}"  >
            </div>
            
            
        </div>
    </div>
      
    </section>
    
    
    
    <section class="vertical-scrolling fp-section fp-table  parrallex" data-anchor="secondSection" style="background:#000 url(images/2.png) no-repeat fixed;" >
      
        <div class="container text-center">
            <div class="col-sm-8 right_side white">
                <h3 style="    font-size: 26px;line-height: 40px;padding-top:100px" class="padding_to_small">  أكثر من 5000 موثق لتوثيق الوكالات وعقود الأنكحة داخل المملكة العربية السعودية، تجد هنا من يخدمك.</h3>
                
                <div class="download  ">
                <a href="http://onelink.to/wathiq"> <img src="{{asset('frontend/images/all.png')}}"> </a>
                <!--<a href=""> <img src="{{asset('frontend/images/ios.png')}}"> </a>-->
                </div>
            </div>
            
            <div class="col-sm-3 imagesmall2">
                <img src="{{asset('frontend/images/iosnew.png')}}">
            </div>
            
        </div>
     
    </section>
    
    <section class="vertical-scrolling fp-section fp-table background_gray" data-anchor="secondSection" >
      
        <div class="container text-center">
            <div class="col-sm-6 right_side">
                <h2>  شرح التطبيق</h2>
                <p> اختر نوع التوثيق، وموقع تقديم الخدمة، والوقت المناسب لك.<br><br>
                يلبي لك سرعة الحصول على موثق ومأذون لتوثيق وكالات شرعية أو عقود، أو توثيق عقد نكاح.<br>

                 </p>
                
            </div>
            
            <div class="col-sm-6">
                <img src="{{asset('frontend/images/ios2.png')}}">
            </div>
            
        </div>
     
    </section>
    
    <section class="vertical-scrolling fp-section fp-table  parrallex" data-anchor="secondSection" style="background:#000 url(images/2.png) no-repeat fixed;" >
      
        <div class="container text-center">
            <div class="col-sm-8 right_side white">
                <h2> موثقوا وثّق</h2>
                <p> 
                <br>
                موثقون و مأذونون مؤهلون ومرخصون من وزارة العدل
                <br>
                <br>
                إذا كنت موثقاً أو مأذوناً نرحب بانضمامك معنا واستقبال طلبات التوثيق
                
                 </p>
                <div class="download ">
                    <a href="http://onelink.to/wathiqksa"> <img src="{{asset('frontend/images/all.png')}}"> </a>
                <!--<a href=""> <img src="{{asset('frontend/images/ios.png')}}"> </a>-->
                </div>
            </div>
            
            <div class="col-sm-3 imagesmall2">
                <img src="{{asset('frontend/images/iosnew2.png')}}">
            </div>
            
        </div>
     
    </section>
    
    <section class="vertical-scrolling fp-section fp-table background_yallow" data-anchor="secondSection" >
      
        <div class="container text-center">
            
            <div class="col-sm-12 padding_0 text-center">
                <div class="logo"><img src="{{asset('frontend/images/logo2.png')}}"></div>
                
                <ul class="menue-top-in">
                <p>قنوات التواصل الإجتماعي</p>
                    <li class="last-child footer_socail">
                        <a href="https://www.facebook.com/wathiqksa"><i class="fa fa-facebook" aria-hidden="true"></i></a> 
                        <a href="https://twitter.com/wathiqksa"><i class="fa fa-twitter" aria-hidden="true"></i></a> 
                        <a href="https://www.instagram.com/wathiqksa/"><i class="fa fa-instagram" aria-hidden="true"></i> </a> 
                        
                        <a href="https://play.google.com/store/apps/details?id=com.watheq.watheq"><i class="fa fa-android"></i> </a> 
                        <a href="https://itunes.apple.com/app/%D9%88%D8%AB-%D9%82/id1330268698?mt=8"><i class="fa fa-apple"></i> </a> 
                    </li>
                </ul>
                
                <div class="download margin_top_50">
                    <!--<a href="http://onelink.to/g5xrvr"> <img src="{{asset('frontend/images/all.png')}}"> </a>-->
                <!--<a href=""> <img src="{{asset('frontend/images/ios.png')}}"> </a>-->
                </div>
                
            </div>
            
        </div>
     
    </section>
    
</div>
 
  </body>
</html>