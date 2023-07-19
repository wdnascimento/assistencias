@extends('layouts.app')
@section('content')
<div class="container">
    <button onclick="notifyMe()">Notify me!</button>
    <script>

        function notifyMe() {
            if (!("Notification" in window)) {
                // Check if the browser supports notifications
                alert("Este navegador não suporta Notificações");
            } else if (Notification.permission === "granted") {
                // Check whether notification permissions have already been granted;
                // if so, create a notification
                const notification = new Notification("Nextone");
                // …
            } else if (Notification.permission !== "denied") {
                // We need to ask the user for permission
                Notification.requestPermission().then((permission) => {
                    // If the user accepts, let's create a notification
                    if (permission === "granted") {
                        const notification = new Notification("Nextone");
                        // …
                    }
                });
            }
            // At last, if the user has denied notifications, and you
            // want to be respectful there is no need to bother them anymore.
        }


    </script>
    <div class="card">
        <div class="card-header">Chats</div>
        <div class="card-body">
            <chat-messages :messages="messages"></chat-messages>
        </div>
        <div class="card-footer">
            <chat-form v-on:messagesent="addMessage" :user="{{ Auth::user() }}"></chat-form>
        </div>
    </div>
</div>
@endsection

<script type="module" src="{{ asset('js/app_chat.js') }}" ></script>
