<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/brand/shu-logo.png') }}" type="image/x-icon">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Hudhud IT')">
    @yield('meta')

    @stack('before-styles')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    <livewire:styles />
    @stack('after-styles')
</head>
<body style="background: #c9c9c9;">
@include('includes.partials.logged-in-as')

<div id="app">
    {{--        @include('frontend.includes.nav')--}}
    @include('includes.partials.messages')

    <main class="py-5">
        <div class="py-3 text-center">
            <img class="img-fluid" width="7%" height="7%" src="{{ asset('img/brand/khadamati-logo.png') }}" alt="khadamati logo" loading="lazy" />
        </div>
        @yield('content')
        <hr />
        <footer class="c-footer text-center text-white">
            <div>
                <strong style="color: black">
                    @lang('Copyright') &copy; {{ date('Y') }}
                    <x-utils.link href="" target="_blank" :text="__(appName())" />
                </strong>

                <span style="color: black">@lang('All Rights Reserved')</span>
            </div>

            <div class="mfs-auto">
                <span style="color: black">@lang('Powered by')</span>
                {{--                    <x-utils.link href="" target="_blank" :text="__(appName())" /> &--}}
                <x-utils.link href="#" target="_blank" text="Omar Al-Rantisi" />
            </div>
        </footer>
    </main>
</div><!--app-->

@stack('before-scripts')
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/frontend.js') }}"></script>
<livewire:scripts />
@stack('after-scripts')
</body>
</html>
