<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistema de Gestión Agropecuaria</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="{!! asset('css/styles.css') !!}"> 
        <!--<link rel="stylesheet" type="text/css" href="{!! asset('css/bootstrap4/bootstrap.min.css') !!}"> -->
        <style>
            body { font-family: 'Nunito'; }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endif
                </div>
            @endif
        </div> <!--fin -->
        
        <div class="container">
            <div class="row">
                <div class="col">
                    <img class="logo" src="{{ asset('imagenes/logo-vaca-fondo-blanco.png') }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h1 class="title">SISTEMA DE GESTIÓN AGROPECUARIA</h1>
                </div>
            </div>
        </div>
    </body>
</html>
