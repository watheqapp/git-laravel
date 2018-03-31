@extends('backend.layouts.list')

@section('js')
@parent

<div class="modal fade" id="assignLawyerModal" tabindex="-1" role="basic"  aria-hidden="true">

</div>

<script>

$(document).ready(function () {
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

