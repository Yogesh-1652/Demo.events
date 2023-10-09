const navItems = document.querySelector('.nav_items');
const openNavbtn = document.querySelector('#open_nav-btn');
const closeNavbtn = document.querySelector('#close_nav-btn');
// open nav dropdown
const openNav = () => {
    navItems.style.display = 'flex'
    openNavbtn.style.display = 'none'
    closeNavbtn.style.display = 'inline-block'
}

// close nav dropdown
const closeNav = () => {
    navItems.style.display = 'none'
    openNavbtn.style.display = 'inline-block'
    closeNavbtn.style.display = 'none'
}

openNavbtn.addEventListener('click', openNav);
closeNavbtn.addEventListener('click', closeNav);


const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show_sidebar-btn');
const hideSidebarBtn = document.querySelector('#hide_sidebar-btn');

// shows sidebar on small devices
const showSidebar = () => {
    sidebar.style.left = '0';
    showSidebarBtn.style.display = 'none';
    hideSidebarBtn.style.display = 'inline-block'
}

// hide sidebar on small devices
const hideSidebar = () => {
    sidebar.style.left = '-100%';
    showSidebarBtn.style.display = 'inline-block';
    hideSidebarBtn.style.display = 'none'
}
showSidebarBtn.addEventListener('click', showSidebar)
hideSidebarBtn.addEventListener('click', hideSidebar)