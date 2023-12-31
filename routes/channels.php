<?php

use App\Events\AulaSalaEvent;
use App\Events\FilasAtivasEvent;
use App\Events\PainelSalaEvent;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('filaaula.{id}', FilasAtivasEvent::class);
Broadcast::channel('aulasala.{id}', AulaSalaEvent::class);
Broadcast::channel('painelsala.{id}', PainelSalaEvent::class);




