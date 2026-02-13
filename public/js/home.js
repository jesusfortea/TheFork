document.addEventListener('click', function (e) {
    const dropdown = document.getElementById('user-dropdown');
    const trigger  = document.getElementById('user-dropdown-btn');
    if (dropdown && trigger && !trigger.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});