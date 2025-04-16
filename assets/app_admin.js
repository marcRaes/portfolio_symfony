import './bootstrap.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import '@popperjs/core';
import './styles/app_admin.css';

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const toggleIcon = toggleBtn.querySelector('img');
    const imageLeft = toggleBtn.dataset.imageLeft;
    const imageRight = toggleBtn.dataset.imageRight;
    const labels = sidebar.querySelectorAll('.logo-admin span, .nav-link span, .dropdown-toggle strong');

    function updateIcon() {
        if (sidebar.classList.contains('collapsed')) {
            toggleIcon.src = imageRight;
        } else {
            toggleIcon.src = imageLeft;
        }
    }

    toggleBtn.appendChild(toggleIcon);
    updateIcon();

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        sidebar.classList.toggle('p-3');
        sidebar.classList.toggle('p-1');

        labels.forEach(label => {
            if (sidebar.classList.contains('collapsed')) {
                sidebar.style.width = '80px';
            } else {
                sidebar.style.width = '280px';
            }
        });

        updateIcon();
    });
});