const toggleButton = document.getElementById('toggleBtn');
const sidebar = document.getElementById('sidebar');

function toggleSidebar(){
    sidebar.classList.toggle('close');
    toggleButton.classList.toggle('rotate');
}
