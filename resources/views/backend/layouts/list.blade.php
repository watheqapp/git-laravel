@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                @if(Session::has('success'))
                <div class="text-center alert alert-success no-border">
                    <button type="button" class="close" data-dismiss="alert">
                        <span>×</span>
                        <span class="sr-only">Close</span></button>
                    {{__('backend.'.Session::get('success'))}}
                </div>
                @endif

                @if(Session::has('error'))
                <div class="text-center alert alert-danger no-border">
                    <button type="button" class="close" data-dismiss="alert">
                        <span>×</span>
                        <span class="sr-only">Close</span></button>
                    {{__('backend.'.Session::get('error'))}}
                </div>
                @endif

                @if(isset($addButtonRoute))
                <a class="btn btn-sm green table-group-action-submit" title="{{__('backend.Add').' '.__('backend.'.$listNameSingle)}}"  href="{{route($addButtonRoute)}}"><i class="fa fa-plus"></i> {{__('backend.Add').' '.__('backend.'.$listNameSingle)}}</a>
                @endif

                @if(isset($export) && $export)
                <a class="btn btn-w-m btn-info btn-rounded" title="{{__('backend.Export')}}"  href="{{route($exportAction)}}"><i class="fa fa-file-excel-o"></i> {{__('backend.Export')}}</a>
                @endif
            </div>
            <div class="portlet-body">
                <div class="table-responsive" style="overflow-x: inherit;">
                    @section('listTable')
                    <table id="datatable-table" class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                @foreach ($columns as $column)
                                @if($column == 'id')
                                @continue
                                @endif
                                <th>{{__('backend.'.$column)}}</th>
                                @endforeach
                                <th>{{__('backend.Actions')}}</th>
                            </tr>
                        </thead>
                    </table>
                    @show
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" role="basic"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn green btn-outline dev-confirm">{{__('backend.Yes')}}</button>
                <button type="button" class="btn red btn-outline" data-dismiss="modal">{{__('backend.Cancel')}}</button>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section('css')
<style>
    div.dataTables_wrapper div.dataTables_filter {
        text-align: left;
    }
    .dataTables_length {
        float: none;
    }
    div.dataTables_wrapper div.dataTables_paginate {
        text-align: inherit;
    }
</style>
@endsection

@section('js')
<script>
    var oTable;
    $(function () {
        oTable = $('#datatable-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: '{{ route($listAjaxRoute) }}',
            language: {
                "sEmptyTable": "{{__('backend.No data available in table')}}",
                "sInfo": "{{__('backend.Showing _START_ to _END_ of _TOTAL_ entries')}}",
                "sInfoEmpty": "{{__('backend.Showing 0 to 0 of 0 entries')}}",
                "sInfoFiltered": "{{__('backend.(filtered from _MAX_ total entries)')}}",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "{{__('backend.Show _MENU_ entries')}}",
                "sLoadingRecords": "{{__('backend.Loading...')}}",
                "sProcessing": "{{__('backend.Processing...')}}",
                "sSearch": "{{__('backend.Search:')}}",
                "sZeroRecords": "{{__('backend.No matching records found')}}",
                "oPaginate": {
                "sFirst": "{{__('backend.First')}}",
                        "sLast": "{{__('backend.Last')}}",
                        "sNext": "{{__('backend.Next')}}",
                        "sPrevious": "{{__('backend.Previous')}}"
                },
                "oAria": {
                "sSortAscending": ": {{__('backend.activate to sort column ascending')}}",
                        "sSortDescending": ": {{__('backend.activate to sort column descending')}}"
                }
            },
            "drawCallback": function( settings ) {
                $('p.td-bg').each(function(e, v){
                    $(this).parent().css('background-color', $(this).attr('data-color'));
                });
            }
        });
    
        $('a[data-action=reload]').on('click', function (e) {
            oTable.draw();
            e.preventDefault();
        });

        var actionMsg = "{{__('backend.List action message', ['action' => '%action%', 'item' => '%item%'])}}";
    
        $('body').on('click', '.dev-list-ajax-action', function () {
            var clickedObj = $(this);
            showConfirmationBox(actionMsg.replace('%action%', clickedObj.attr('title')).replace('%item%', clickedObj.attr('data-name')), function () {
                $.ajax({
                    url: clickedObj.attr('data-href'),
                    success: function (resp) {
                        oTable.draw();
                        showNotification(resp.status, resp.message);
                    }
                });
            }, $(this).attr('title'));
        });

        $('#confirmationModal .dev-confirm').click(function () {
            $('#confirmationModal').modal('hide');
            callbackFunction();
        });
    
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    
    function showConfirmationBox(confimationMessage, onConfirmFunction, confirmationBoxTitle, onCancelFunction) {
        var $confirmationModal = $('#confirmationModal');
        if (confirmationBoxTitle) {
            $confirmationModal.find('.modal-title').html(confirmationBoxTitle);
        } else {
            $confirmationModal.find('.modal-title').html();
        }
        
        $confirmationModal.find('.modal-body').text(confimationMessage);
        $confirmationModal.modal({keyboard: true});
        $confirmationModal.on('shown.bs.modal', function () {
            if (window.location == window.parent.location) {
                $confirmationModal.find('button.dev-confirm').focus();
            }
        });
        
        $confirmationModal.modal('show');
        $confirmationModal.on('hidden.bs.modal', function (e) {
            if (onCancelFunction)
                    onCancelFunction();
        });
        callbackFunction = onConfirmFunction;
    }


    function showNotification(type, txt) {
        toastr.options.rtl = true;
        toastr.options.positionClass = 'toast-top-left';
        toastr.options.progressBar = true;

        if (type == 'error') {
            toastr.error(txt, "{{__('backend.notification')}}")
        }

        if (type == 'success') {
            toastr.success(txt, "{{__('backend.notification')}}")
        }
    }
</script>
@endsection
