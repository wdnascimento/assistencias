<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Http;

class GoogleRecaptcha implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return $this->validateRecaptcha($value);
    }

    public function message()
    {
        return 'The google recaptcha challenge is not correct.';
    }

    private function validateRecaptcha($value) : bool
    {
        $GOOGLE_RECAPTCHA_URL = env('GOOGLE_RECAPTCHA_URL','https://www.google.com/recaptcha/api/siteverify');
        $GOOGLE_RECAPTCHA_SECRET_KEY = env('GOOGLE_RECAPTCHA_SECRET_KEY','6LfA5egnAAAAAHU0LRiNsOJVxJXJOX6ma5qGzNsj');
        $value = [
            'secret' => $GOOGLE_RECAPTCHA_SECRET_KEY,
            'response' => $value
        ];
        $response = Http::asForm()->post(
            $GOOGLE_RECAPTCHA_URL ,$value

        );
        $body = json_decode((string)$response->getBody());
        if((bool)$body->success){
            return true;
        }
        return false;
    }
}
