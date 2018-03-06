@extends('backend.layouts.list')
@section('listTable')

<br />
<div class="">
    <span class="badge badge-roundless" style="background-color: #F1C40F;">{{__('backend.clerk')}}</span>
    <span class="badge badge-roundless" style="background-color: #36c6d3;">{{__('backend.authorized')}}</span>
    <span class="badge badge-roundless" style="background-color: #ccc;">{{__('backend.activeted')}}</span>
    <span class="badge badge-roundless" style="background-color: red;">{{__('backend.Not login yet')}}</span>
    <br /><br />
    @parent
</div>

@endsection