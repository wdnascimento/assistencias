<?php
    namespace App\Exceptions;

    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    use Illuminate\Auth\AuthenticationException;
    class Handler extends ExceptionHandler
    {

        protected function unauthenticated($request, AuthenticationException $exception)
        {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            $guard = $exception->guards();
           // dd($guard[0]);
            switch ($guard[0]) {
                case 'professor':
                    $login = 'professor.auth.login';
                break;
                case 'sanctum':
                    return response()->json(['error' => 'ok.'], 200);
                break;
                case 'admin':
                    $login = 'admin.auth.login';
                break;
                default:
                    $login = 'login';
                break;
            }
            return redirect()->guest(route($login));
        }
    }
