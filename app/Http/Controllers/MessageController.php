<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(){
        broadcast(new MyEvent('Hello Word'))->toOthers();
    }
}
