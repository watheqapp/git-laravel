<link href="{{asset('backend-assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('backend-assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<div class="row">
    <div class="portlet light bordered">

        <?php
        $defaultFormAttribute = ['method' => 'POST', 'route' => ['backend.pushnotification.create'], 'class' => 'form-horizontal'];
        if (count($formAttributes) > 0) {
            $defaultFormAttribute = array_merge($defaultFormAttribute, $formAttributes);
        }
        ?>
        <div class="portlet-body form">
            {!! Form::open($defaultFormAttribute) !!}
                @include('backend.common.fields.select', ['name' => 'userType', 'value' => $userTypes])
                <div class="form-group {{ $errors->has('userId') ? 'has-error' : ''}}">
                    <label class="control-label col-lg-2"> {{__('backend.userId')}} </label>
                    <div class="col-sm-10">
                        {!! Form::select('userId', [], null, ['class' => ' form-control']) !!}
                    </div>
                </div>
                @include('backend.common.fields.text', ['name' => 'title'])
                @include('backend.common.fields.textarea', ['name' => 'content'])
                @include('backend.common.fields.submit')
            {!! Form::close() !!}
        </div>
    </div>
</div>