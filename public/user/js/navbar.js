document.addEventListener('DOMContentLoaded', function () {
    const dropdownToggle = document.querySelector('.dropdown > a');
    const dropdownMenu = document.querySelector('.dropdown .dropdown-menu');

    if (dropdownMenu) {
        dropdownMenu.style.display = 'none';
    }

    if (dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener('click', function (e) {
            e.preventDefault();
            const isVisible = dropdownMenu.style.display === 'block';
            dropdownMenu.style.display = isVisible ? 'none' : 'block';
        });

        document.addEventListener('click', function (e) {
            if (!dropdownToggle.closest('.dropdown').contains(e.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    }
});