// Social links hover effects
document.querySelectorAll('.social-link').forEach(link => {
    link.addEventListener('mouseenter', function () {
        this.style.background = 'linear-gradient(135deg, #003366, #0066cc)';
        this.style.transform = 'translateY(-3px)';
    });
    link.addEventListener('mouseleave', function () {
        this.style.background = 'rgba(255,255,255,0.1)';
        this.style.transform = 'translateY(0)';
    });
});

// Footer links hover effects
document.querySelectorAll('.footer-section ul li a').forEach(link => {
    link.addEventListener('mouseenter', function () {
        this.style.color = '#0066cc';
        this.style.paddingLeft = '10px';
        this.style.transition = 'all 0.3s ease';
    });
    link.addEventListener('mouseleave', function () {
        this.style.color = '#a0aec0';
        this.style.paddingLeft = '0';
    });
});