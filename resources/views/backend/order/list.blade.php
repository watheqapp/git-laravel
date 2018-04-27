@extends('backend.layouts.list')

@section('js')
@parent

<div class="modal fade" id="assignLawyerModal" tabindex="-1" role="basic"  aria-hidden="true">

</div>

<div class="modal fade" id="changeStatusModal" tabindex="-1" role="basic"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title">{{__('backend.Change order status')}}</h4>
            </div>
            <div class="modal-body">
                <?php
                $defaultFormAttribute = [
                    'method' => 'POST',
                    'url' => ['/backend/order/change-status'],
                    'class' => 'form-horizontal'
                ];
                ?>
                {!! Form::open($defaultFormAttribute) !!}
                    {!! Form::hidden('orderId', '') !!}
                    @include('backend.common.fields.select', ['name' => 'status', 'value' => $availableStatus])
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn green btn-outline dev-submit-btn">{{__('backend.Save')}}</button>
                <button type="button" class="btn red btn-outline" data-dismiss="modal">{{__('backend.Cancel')}}</button>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function () {
    $('body').on('click', '.dev-change-status-action', function () {
        $('#changeStatusModal').find('input[name=orderId]').val($(this).attr('data-id'));
        $('#changeStatusModal').modal('show');
    });

    $('body').on('click', '#changeStatusModal .dev-submit-btn', function () {
        var statusForm = $('#changeStatusModal form');
//        if(!statusForm.valid()){
//            return false;
//        }
        $.ajax({
            url: '{{route("backend.order.changeStatus")}}',
            type: 'POST',
            data: statusForm.serialize(),
            success: function (resp) {
                $('#changeStatusModal').modal('hide');
                oTable.draw();
                showNotification(resp.status, resp.message);
            }
        });
    });


    $('body').on('click', '.dev-assign-lawyer-action', function () {
        var clickedObj = $(this);
        var assignUrl = clickedObj.attr('data-href');
        $.ajax({
            url: assignUrl,
            type: 'GET',
            success: function (resp) {
                if(resp.status == 'success') {
                    return $('#assignLawyerModal').html(resp.view).modal('show');
                }
                oTable.draw();
                showNotification(resp.status, resp.message);
            }
        });
    });

    $('body').on('click', '#assignLawyerModal .dev-submit-btn', function () {
        var assignForm = $('#assignLawyerModal form');
        if(!assignForm.valid()){
            return false;
        }
        $.ajax({
            url: '{{route("backend.order.assignLawyer")}}',
            type: 'POST',
            data: assignForm.serialize(),
            success: function (resp) {
                $('#assignLawyerModal').modal('hide');
                oTable.draw();
                showNotification(resp.status, resp.message);
            }
        });
    });

})
</script>


@endsection

