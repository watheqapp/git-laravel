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
            @include('backend.common.fields.select', ['name' => 'lawyerId', 'value' => $lawyers])
            {!! Form::close() !!}

        </div>
        <div class="modal-footer">
            <button type="button" class="btn green btn-outline dev-submit-btn">{{__('backend.Assign')}}</button>
            <button type="button" class="btn red btn-outline" data-dismiss="modal">{{__('backend.Cancel')}}</button>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script>
    $(document).ready(function() {
        jQuery.validator.setDefaults({
            ignore: ''
        });
    });
</script>

{!! $validator !!}










