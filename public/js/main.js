function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    var trigger = document.getElementById('sidebarTrigger');
    var icon = trigger.querySelector('i');
    if (sidebar) {
        var isExpanded = !sidebar.classList.contains('expanded');
        sidebar.classList.toggle('expanded');
        
        if (isExpanded) {
            sidebar.classList.add('expanded');
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-chevron-left');
            localStorage.setItem('sidebarOpen', '1');
        } else {
            sidebar.classList.remove('expanded');
            icon.classList.remove('fa-chevron-left');
            icon.classList.add('fa-chevron-right');
            localStorage.setItem('sidebarOpen', '0');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('sidebar');
    var trigger = document.getElementById('sidebarTrigger');
    var icon = trigger.querySelector('i');
    var isOpen = localStorage.getItem('sidebarOpen') === '1';
    
    if (isOpen && sidebar) {
        sidebar.classList.add('expanded');
        if (icon) {
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-chevron-left');
        }
    }
});
