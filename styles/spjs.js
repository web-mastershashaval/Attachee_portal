 // Toggle Sidebar
 const sidebar = document.getElementById('sidebar');
 const mainContent = document.getElementById('mainContent');
 const topNavBar = document.getElementById('topNavBar');
 const menuIcon = document.getElementById('menuIcon');

 menuIcon.addEventListener('click', () => {
     sidebar.classList.toggle('hidden');
     mainContent.classList.toggle('expanded');
     topNavBar.classList.toggle('expanded');
 });

 document.querySelectorAll('a[href^="#"]').forEach(anchor => {
 anchor.addEventListener('click', function(e) {
     e.preventDefault();
     const target = document.querySelector(this.getAttribute('href'));
     if (target) {
         target.scrollIntoView({ behavior: 'smooth' });
     }
 });
});