document.addEventListener('DOMContentLoaded', () => {
    const darkModeToggle = document.getElementById('flexSwitchCheckDefault');

    // Apply saved mode from localStorage
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        if (darkModeToggle) {
            darkModeToggle.checked = true;
        }
    }

    // Toggle and save preference
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', () => {
            const enabled = darkModeToggle.checked;
            document.body.classList.toggle('dark-mode', enabled);
            localStorage.setItem('darkMode', enabled);
        });
    }
});
