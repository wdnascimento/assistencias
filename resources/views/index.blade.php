<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Next - Gestor de Atendimentos</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <link rel="shortcut icon" href="{{ asset('favicon/favicon-96x96.png') }}" type="image/png">
        <link rel="icon" href="{{ asset('favicon/favicon-96x96.png') }}" type="image/png">
        <!-- Styles -->
    </head>
    <body>
        <header class="bg-white shadow-sm">
            <div class="container p-3">
                <div class="row d-flex">
                    <div class="col-6 d-flex justify-content-start left">
                        <a href="{{ asset('') }}">
                            <img src="{{ asset('image/LogoNext500px.png') }}" alt="Next" width="100px" height="auto" class="logomarca">
                        </a>
                    </div>
                    <div class="col-6 d-flex justify-content-end right">
                        <img src="{{ asset('image/Positivo.png') }}" alt="Positivo" width="140px" height="auto" class="logomarca">
                    </div>
                </div>
            </div>
        </header>
        <main class="mt-3">
            <div class="container">
                <div  id="" class="row justify-content-center flex-wrap pt-5"">
                    <div class="col-12 col-md-6 col-lg-6 col-xl-6  " onclick="window.location.href='{{ url('aluno') }}'">
                        <div   class="d-flex home-icons-main w-100 shadow p-3 mb-5 rounded">
                            <h1>Aluno</h1>
                        </div>


                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-6  " onclick="window.location.href='{{ url('professor') }}'">
                        <div   class="d-flex home-icons-main w-100 shadow p-3 mb-5 rounded">
                            <h1>Professor</h1>
                        </div>
                    </div>
                    {{-- <div class="m-3 p-5 " onclick="window.location.href='{{ url('admin') }}'">
                        <h1>Admin</h1>
                    </div> --}}
            </div>
            </div>

        </main>
        <footer class="footer">
            <!-- Copyright -->
            <div class="container text-center text-black">
                <a class="dark-grey-text" href="https://wnascimento.com.br"><img src="{{ asset('image/LogoNext500px.png') }}" alt="Next" width="50px" height="auto" class="logomarca"></a> © 2020 Copyright
            </div>
            <!-- Copyright -->
        </footer>

    </body>



</html>
@section('js')
    {{-- <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('plugin/jquery.mask.min.js') }}" ></script>
    <script src="{{ asset('js/scripts.js') }}" ></script> --}}
@endsection
