
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>تطبيق وثق  | الاسئلة المكررة </title>

        <!-- Bootstrap core CSS -->
        <link href="{{asset('css/bootstrap-terms.min.css')}}" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{{asset('css/terms.css')}}" rel="stylesheet">
    </head>

    <body>

        <div class="container">
            <div class="header clearfix">
                <div style="text-align: center">
                    <img class="img-responsive" src="{{asset('backend-assets//layouts/layout4/img/playstore-icon.png')}}" />
                    <h4 style="text-align: center">‎تطبيق وثق -الاسئلة المكررة </h4>
                </div>
            </div>

            <div class="jumbotron">
                {!! $page->content !!}
            </div>


            <footer class="footer">
                <p>&copy; جميع الحقوق محفوظة لتطبيق وثق 2017</p>
            </footer>

        </div> <!-- /container -->

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="{{asset('js/ie10-viewport-bug-workaround.js')}}"></script>
    </body>
</html>
