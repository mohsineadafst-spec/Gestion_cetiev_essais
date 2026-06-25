import './bootstrap';

import Alpine from 'alpinejs';
import Echo from "laravel-echo";
import io from "socket.io-client";
import collapse from '@alpinejs/collapse'

Alpine.plugin(collapse)
window.Alpine = Alpine
Alpine.start()


window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});



window.Alpine = Alpine;

Alpine.start();
