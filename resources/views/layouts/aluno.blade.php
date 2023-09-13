<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Positivo - Gestor de Assistências</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> --}}

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        @include('layouts.favicon')
        <!-- Styles -->
    </head>
    <body>
        <header class="bg-white shadow-sm">
            <div class="container p-3">
                <!-- Authentication Links -->
                @guest
                    <div class="row d-flex">
                        <div class="col-6 d-flex justify-content-end right">
                            <img src="{{ asset('image/Positivo.png') }}" alt="Positivo" width="140px" height="auto" class="positivo">
                        </div>
                    </div>
                @else
                    <div class="row d-flex">
                        <div class="col-9 d-flex justify-content-start right">
                            <img src="{{ asset('image/Positivo.png') }}" alt="Positivo" width="140px" height="auto" class="">
                        </div>
                        <div class="col-3 d-flex justify-content-end right">
                            <button type="button" class="btn btn-dark"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            ><strong>Sair</strong></button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>

                    </div>
                @endguest


            </div>
        </header>
        <main class="mt-3">
            @yield('content')
        </main>
        <footer class="footer">
            <!-- Copyright -->
            <div class="container text-center text-black">
                 © 2023 Copyright
            </div>
            <!-- Copyright -->
        </footer>

    </body>

<script src="{{ asset('js/aluno/app.js') }}" ></script>
<script src="{{ asset('plugin/jquery.mask.min.js') }}" ></script>
<script src="{{ asset('js/scripts.js') }}" ></script>

</html>
