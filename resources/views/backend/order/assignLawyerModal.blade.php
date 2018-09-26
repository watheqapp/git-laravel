<link href="{{asset('backend-assets/plugins/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
<style type="text/css">
    .inputpicker-wrapped-list {
        z-index: 100000 !important;
    }

    .inputpicker-div {
        width: 100% !important;
    }

    .inputpicker-input {
        padding-right: 20px;
    }
</style>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
            <h4 class="modal-title">{{__('backend.Assign lawyer')}}</h4>
        </div>
        <div class="modal-body">
            <?php
                $defaultFormAttribute = [
                    'method' => 'POST',
                    'url' => ['/backend//store'],
                    'class' => 'form-horizontal'
                ];
            ?>
            {!! Form::open($defaultFormAttribute) !!}
            {!! Form::hidden('orderId', $order->id) !!}
            <input class="form-control" name="lawyerId" id="assign-lawyers" placeholder="اختر الموثق" />
            {!! Form::close() !!}

        </div>
        <div class="modal-footer">
            <button type="button" class="btn green btn-outline dev-submit-btn">{{__('backend.Assign')}}</button>
            <button type="button" class="btn red btn-outline" data-dismiss="modal">{{__('backend.Cancel')}}</button>
        </div>
    </div>
</div>

<script src="{{asset('backend-assets/plugins/jquery.inputpicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script>
    $(document).ready(function() {
        jQuery.validator.setDefaults({
            ignore: ''
        });

        var lawyers = <?php echo $lawyersData ?>;// don't use quotes


        $('#assign-lawyers').inputpicker({
            data: lawyers,
            fields:[
                {name:'id',text:'ID'},
                {name:'name',text:'الاسم'},
                {name:'distance',text:'المسافة'},
                {name:'phone',text:'الجوال'}
            ],
            autoOpen: true,
            headShow: true,
            fieldText : 'name',
            fieldValue: 'id'
        });
    });
</script>


{!! $validator !!}










