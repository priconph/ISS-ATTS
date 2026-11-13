<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ISS ATTS | @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="{{ asset('public/images/favicon.ico') }}">

        <!-- CSS LINKS -->
        @include('shared.css_links.css_links')
        <style>
            .modal-xl-custom{
                width: 95% !important;
                min-width: 90% !important;
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini" style="overflow-y: auto !important;">
        <div class="wrapper">
            @include('shared.pages.admin_header')
            @include('shared.pages.admin_nav')
            @yield('content_page')
            @include('shared.pages.admin_footer')
        </div>

        <!-- JS LINKS -->
        @include('shared.js_links.js_links')
        @yield('js_content')
    </body>
</html>



{{-- @if(!isset($_SESSION))
    @php
        session_start(); 
    @endphp
@endif


@php
    $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
    }
@endphp

@if ($isLogin)
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>SDCRS {{ isset($_SESSION['rapidx_user_level_id']) ? "yes" : "no" }} | @yield('title')</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="shortcut icon" type="image/png" href="{{ asset('public/images/favicon.ico') }}">

            <!-- CSS LINKS -->
            @include('shared.css_links.css_links')
            <style>
                .modal-xl-custom{
                    width: 95% !important;
                    min-width: 90% !important;
                }
            </style>
        </head>
        <body class="hold-transition sidebar-mini">
            <div class="wrapper">
                @include('shared.pages.admin_header')
                @include('shared.pages.admin_nav')
                @yield('content_page')
                @include('shared.pages.admin_footer')
            </div>

            <!-- JS LINKS -->
            @include('shared.js_links.js_links')
            @yield('js_content')
        </body>
    </html>
@else
    <script type="text/javascript">
        window.location = '../RapidX/';
    </script>
@endif --}}