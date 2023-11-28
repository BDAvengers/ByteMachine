function toggleDropdown() {
    var dropdown = document.getElementById("dropdown");
    dropdown.classList.toggle("show");
}

document.addEventListener('click', function (e) {
    var dropdown = document.getElementById("dropdown");
    if (!e.target.matches('.dropdown-toggle')) {
        if (dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    }
});