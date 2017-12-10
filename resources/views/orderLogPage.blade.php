
<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Log orders process</title>

        <!-- Bootstrap core CSS -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('css/log-order.min.css')}}" rel="stylesheet">
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <main class="col-md-12">
                    <h1 class="text-center">{{__('api.Order process logging', [], 'ar')}}</h1>

                    <form class="form-inline" action="{{url('order/log/')}}" type="get">
                        <div class="form-group">
                            <label for="order-id">{{__('api.Order ID', [], 'ar')}}</label> &nbsp;&nbsp;
                            <input id="order-id" class="form-control" required type="text" value="{{App()->request->order}}" name="order" />
                        </div>
                        &nbsp;&nbsp;
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="{{__('api.Check Log', [], 'ar')}}" />
                        </div>
                    </form>
                    <br />
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">{{__('api.Order ID', [], 'ar')}}</th>
                                    <th class="text-center">{{__('api.Log type', [], 'ar')}}</th>
                                    <th class="text-center">{{__('api.Message', [], 'ar')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$log)
                                <tr>
                                    <td colspan="3">{{__('api.No log for this order request', [], 'ar')}}</td>
                                </tr>
                                @else
                                @foreach($log as $record)
                                <tr>
                                    <td>{{$record->order_id}}</td>
                                    <td>{{__('api.'.$record->type, [], 'ar')}}</td>
                                    <td>{!! $record->message !!}</td>
                                </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="{{asset('js/jquery-3.1.1.slim.min.js')}}"></script>
    <script type="text/javascript">
        $(function() {
            setTimeout(function () {
                window.location.reload(1);
            }, 5000);
        });
    </script>
</html>
