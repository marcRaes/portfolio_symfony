import './bootstrap.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import '@popperjs/core';
import './styles/app_admin.css';

document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');

    if (!sidebar || !toggleBtn) return;

    const toggleIcon = toggleBtn.querySelector('img');
    const imageLeft = toggleBtn.dataset.imageLeft;
    const imageRight = toggleBtn.dataset.imageRight;

    function updateSidebarWidth() {
        const isCollapsed = sidebar.classList.contains('collapsed');
        sidebar.style.width = isCollapsed ? '80px' : '280px';
        toggleIcon.src = isCollapsed ? imageRight : imageLeft;
    }

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        sidebar.classList.toggle('p-3');
        sidebar.classList.toggle('p-1');
        updateSidebarWidth();
    });

    updateSidebarWidth();
});
