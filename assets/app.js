import 'bootstrap';
import './bootstrap.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import '@popperjs/core';
import './styles/app.css';
import { Popover } from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');

    popoverTriggerList.forEach(el => {
        new Popover(el, {});
    });
});
