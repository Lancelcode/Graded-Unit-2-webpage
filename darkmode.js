document.addEventListener('DOMContentLoaded', () => {
    const darkModeToggle = document.getElementById('flexSwitchCheckDefault');

    darkModeToggle.addEventListener('change', () => {
        document.body.classList.toggle('dark-mode', darkModeToggle.checked);
    });
});
