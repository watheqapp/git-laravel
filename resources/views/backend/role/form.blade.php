@include('backend.common.fields.text', ['name' => 'name'])
@include('backend.common.fields.textarea', ['name' => 'description'])

<div class="form-group {{ $errors->has('permissions') ? 'has-error' : ''}}" data-error-message-after="table">
    {!! Form::label('permissions[]',  __('backend.permissions'), ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        <table class="table white-bg input-group">
            <thead>
                <tr>
                    <th>{{ __('backend.module')}}</th>
                    <th>{{ __('backend.Manage')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                <tr>
                    <td>{{ __('backend.Manage '.$module)}}</td>
                    <td>
                        <?php if (array_key_exists('role-' . $module, $permissions)) { ?>
                            <div class="i-checks">
                                <label>
                                    {!! Form::checkbox('permissions[]', $permissions['role-'.$module], (isset($document) ? (in_array($permissions['role-'.$module],$document->permissionIds())? true: false):false)) !!} &nbsp;
                                    <i></i>
                                </label>
                            </div>
                        <?php } ?>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {!! $errors->first('permissions', '<span class="help-block">:message</span>') !!}
    </div>
</div>

@include('backend.common.formSubmitBtn')
