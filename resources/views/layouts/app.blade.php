<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <script>
        window.App = {!! json_encode([
        'signedIn' => auth()->check(),
        'user'=>auth()->user()
        ]) !!}
    </script>

    <!-- Styles -->
    <style>
        .blog-footer {
            padding: 40px 0;
            color: #999;
            text-align: center;
            background-color: #f9f9f9;
            border-top: 1px solid #e5e5e5;
        }

        .blog-footer p:last-child {
            margin-bottom: 0;
            align-items: center;
        }

        .level {
            display: flex;
            place-items: center;

        }

        .flex {
            flex: 1;
        }

        .mr-1 {
            margin-right: 1em;
        }

        [v-cloak] {
            display: none;
        }

    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">

    @include('layouts.navbar')

    @yield('content')


    <flash message="{{session('flash_message')}}"></flash>
    {{--<example></example>--}}
    @include('layouts.footer')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>


</body>
</html>
