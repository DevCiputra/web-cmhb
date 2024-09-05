// public/js/navbar.js

// Toggle dropdown on click
document.querySelectorAll('.dropdown-toggle').forEach(function(dropdownToggle) {
    dropdownToggle.addEventListener('click', function(e) {
        e.preventDefault();
        const targetMenu = this.nextElementSibling;

        // Toggle collapse
        if (targetMenu.classList.contains('show')) {
            targetMenu.classList.remove('show');
            targetMenu.style.maxHeight = null;
        } else {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
                menu.style.maxHeight = null;
            });
            targetMenu.classList.add('show');
            targetMenu.style.maxHeight = targetMenu.scrollHeight + "px";
        }
    });
});
