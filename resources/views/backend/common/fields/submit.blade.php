<div class="form-actions">
    {!! Form::submit(__('backend.Save'),['class'=>'btn blue']) !!}
    <button type="button" class="btn default" onclick="window.location.href ='{{ url()->previous() }}'">{{__('backend.Cancel')}}</button>
</div>