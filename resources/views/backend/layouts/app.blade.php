@include('backend.layouts.header')

<div class="page-container">
    @include('backend.layouts.menu')
    <div class="page-content-wrapper">
        <div class="page-content">
            @include('backend.layouts.breadcrumb')
            @yield('content')
        </div>
    </div>
</div>
@include('backend.layouts.footer')

