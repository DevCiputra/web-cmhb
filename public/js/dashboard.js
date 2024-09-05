document.addEventListener("DOMContentLoaded", function() {
    var sidebarCollapse = document.getElementById('sidebarCollapse');
    var sidebar = document.querySelector('.sidebar');

    sidebarCollapse.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
    });
});
