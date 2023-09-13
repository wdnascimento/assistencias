<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Positivo Assistências</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        @include('layouts.favicon')
        <!-- Styles -->
    </head>
    <body>
        <header class="bg-white shadow-sm">
            <div class="container">
                <div class="row d-flex">
                    <div class="d-flex col-12 justify-content-between">
                        <a href="{{ asset('') }}" class="pt-2">
                            <img src="{{ asset('image/LogoPositivo.jpg') }}" alt="Positivo"   >
                        </a>
                        <h4 class="p-0 pt-4 dark font-weight-bold">Assistências</h4>
                    </div>
                </div>
            </div>
        </header>
        <main class="mt-3">
            <div class="container">
                <div  id="" class="row justify-content-center flex-wrap pt-5 px-2"">
                    <div class="col-12 col-md-6 col-lg-6 col-xl-6" >
                        <a href="#" class="pt-2 link-offset-2 link-underline link-underline-opacity-0" onclick="window.location.href='{{ url('aluno') }}'">
                             <div class="shadow-lg p-3 mb-5  rounded p-3 bg-warning text-center">
                                <h1 class="font-weight-bold">Aluno</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                        <a href="#" class="pt-2 link-offset-2 link-underline link-underline-opacity-0" onclick="window.location.href='{{ url('professor') }}'">
                            <div class="shadow-lg p-3 mb-5  rounded p-3 bg-warning text-center">
                                <h1 class="font-weight-bold">Professor</h1>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer">
            <div class="container text-center text-black">
                 © 2023 Copyright
            </div>
        </footer>
    </body>
</html>
