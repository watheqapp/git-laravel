<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        {!! Form::submit(__('backend.Save'),['class'=>'btn btn-w-m btn-primary']) !!}
        <button class="btn btn-danger" onclick="window.location.href ='{{ url()->previous() }}'" type="button">{{__('backend.Cancel')}}<i class="icon-cross2 position-right"></i></button>
    </div>
</div>
<div class="clearfix"></div>
