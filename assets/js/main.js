// Main JavaScript for the user-facing website

document.addEventListener('DOMContentLoaded', function() {
    console.log('Mandorbangun.id website is ready!');

    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            let hash = this.getAttribute('href');
            let target = document.querySelector(hash);
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 80, // Adjust for fixed header height
                    behavior: 'smooth'
                });
            }
        });
    });
});
