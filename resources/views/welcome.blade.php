<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>
    <body>
        <div >
            <header class="container-fluid bg-white shadow-sm">
                <div class="container p-3">
                    <div class="row d-flex">
                        <div class="col-6 d-flex justify-content-start left">
                            <img src="{{ asset('image/LogoNext500px.png') }}" alt="Next" width="100px" height="auto" class="logomarca">
                            <img src="{{ asset('image/Positivo.png') }}" alt="Next" width="140px" height="auto" class="ml-2 logomarca positivo">
                        </div>
                        <div class="col-6 d-flex justify-content-end right">
                            <button type="button" class="btn btn-primary"><strong>Sair</strong></button>
                        </div>
                    </div>

                </div>
            </header>
            <div id="app" class="container mt-3">
                <contador></contador>
            </div>
            <footer>

            </footer>
        </div>


    </body>

<script src="{{ asset('js/app.js') }}" ></script>
</html>
