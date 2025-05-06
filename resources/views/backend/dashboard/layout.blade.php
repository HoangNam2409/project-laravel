<!DOCTYPE html>
<html>

<head>
    {{-- Head --}}
    @include('backend.dashboard.components.head')
</head>

<body>
    <div id="wrapper">
        {{-- Sidebar --}}
        @include('backend.dashboard.components.sidebar')

        <div id="page-wrapper" class="gray-bg">
            {{-- Header --}}
            @include('backend.dashboard.components.nav')
            {{-- Home --}}
            @include($template)
            {{-- Footer --}}
            @include('backend.dashboard.components.footer')
        </div>
    </div>

    {{-- Script --}}
    @include('backend.dashboard.components.script')
</body>

</html>
