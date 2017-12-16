@extends('backend.layouts.app')
@section('css')
<link href="{{ asset('backend-assets/apps/scripts/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@yield('form')
@endsection

@section('js')
@parent
<script type="text/javascript" src="{{ asset('backend-assets/apps/scripts/jasny/jasny-bootstrap.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyCX3Mq_o4NIIwo09__ZJYxdCNwqoOnusjI"></script>
<script>

    $(document).ready(function () {


    });
</script>
<script>
    $(document).ready(function() {

    if (typeof CKEDITOR != "undefined"){
        CKEDITOR.on('instanceReady', function () {
            $.each(CKEDITOR.instances, function (instance) {
                CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
                CKEDITOR.instances[instance].document.on("paste", CK_jQ);
                CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
                CKEDITOR.instances[instance].document.on("blur", CK_jQ);
                CKEDITOR.instances[instance].document.on("change", CK_jQ);
            });
        });
    }
    
    function CK_jQ() {
        $('textarea.ckeditor').each(function () {
            var $textarea = $(this);
            $textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
                //$textarea.valid();
        });
    }
    
    jQuery.validator.setDefaults({
        ignore: ''
     });
 });
</script>

{!! $validator !!}
@endsection









