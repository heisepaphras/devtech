// Hero Slider Variables
let slideIndex = 1;
let slideTimer;

// Testimonial Slider Variables
let testimonialIndex = 1;
let testimonialTimer;

// Initialize sliders on page load
document.addEventListener('DOMContentLoaded', () => {
    showSlide(slideIndex);
    showTestimonial(testimonialIndex);
    autoSlide();
    autoTestimonial();
});

// Hero Slider Functions
function changeSlide(n) {
    clearTimeout(slideTimer);
    showSlide(slideIndex += n);
    autoSlide();
}

function currentSlide(n) {
    clearTimeout(slideTimer);
    showSlide(slideIndex = n);
    autoSlide();
}

function showSlide(n) {
    let slides = document.getElementsByClassName("slide");
    let dots = document.getElementsByClassName("dot");
    let counter = document.querySelector(".current-slide");
    
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("fade");
    }
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    
    slides[slideIndex - 1].classList.add("fade");
    dots[slideIndex - 1].classList.add("active");
    
    if (counter) {
        counter.textContent = slideIndex;
    }
}

function autoSlide() {
    slideTimer = setTimeout(() => {
        slideIndex++;
        showSlide(slideIndex);
        autoSlide();
    }, 5000); // Change slide every 5 seconds
}

// Testimonial Slider Functions
function changeTestimonial(n) {
    clearTimeout(testimonialTimer);
    showTestimonial(testimonialIndex += n);
    autoTestimonial();
}

function currentTestimonial(n) {
    clearTimeout(testimonialTimer);
    showTestimonial(testimonialIndex = n);
    autoTestimonial();
}

function showTestimonial(n) {
    let testimonials = document.getElementsByClassName("testimonial-slide");
    let dots = document.getElementsByClassName("testimonial-dot");
    
    if (n > testimonials.length) {
        testimonialIndex = 1;
    }
    if (n < 1) {
        testimonialIndex = testimonials.length;
    }
    
    for (let i = 0; i < testimonials.length; i++) {
        testimonials[i].classList.remove("active");
    }
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    
    testimonials[testimonialIndex - 1].classList.add("active");
    dots[testimonialIndex - 1].classList.add("active");
}

function autoTestimonial() {
    testimonialTimer = setTimeout(() => {
        testimonialIndex++;
        showTestimonial(testimonialIndex);
        autoTestimonial();
    }, 6000); // Change testimonial every 6 seconds
}

// Smooth scrolling and navigation
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', (e) => {
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        link.classList.add('active');
    });
});

function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
        // Update active nav link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        const activeLink = document.querySelector(`[href="#${sectionId}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }
    }
}

// Tab switching for players section
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected tab
    const selectedTab = document.getElementById(tabName + '-tab');
    if (selectedTab) {
        selectedTab.classList.add('active');
    }

    // Add active class to clicked button
    event.target.classList.add('active');
}

// Tab switching for transfer section
function switchTransferTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.transfer-tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active class from all buttons
    document.querySelectorAll('.transfer-tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected tab
    const selectedTab = document.getElementById(tabName);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }

    // Add active class to clicked button
    event.target.classList.add('active');
}

// Form submission handling
function handleSubmit(event) {
    event.preventDefault();

    const formData = {
        fullname: document.getElementById('fullname').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        age: document.getElementById('age').value,
        position: document.getElementById('position').value,
        program: document.getElementById('program').value,
        experience: document.getElementById('experience').value,
        message: document.getElementById('message').value
    };

    // Validate form
    if (!formData.fullname || !formData.email || !formData.phone || !formData.age) {
        alert('Please fill in all required fields');
        return;
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(formData.email)) {
        alert('Please enter a valid email address');
        return;
    }

    // Phone validation
    if (formData.phone.length < 10) {
        alert('Please enter a valid phone number');
        return;
    }

    // Age validation
    if (formData.age < 8 || formData.age > 30) {
        alert('Age should be between 8 and 30');
        return;
    }

    // Success message
    console.log('Form submitted:', formData);
    
    // Store in localStorage (optional)
    let registrations = JSON.parse(localStorage.getItem('registrations')) || [];
    registrations.push({
        ...formData,
        registrationDate: new Date().toLocaleDateString()
    });
    localStorage.setItem('registrations', JSON.stringify(registrations));

    // Show success message
    alert(`Thank you ${formData.fullname}! Your registration has been submitted successfully. We will contact you within 24 hours.`);

    // Reset form
    document.querySelector('.registration-form').reset();
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Hamburger menu functionality
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

if (hamburger) {
    hamburger.addEventListener('click', () => {
        navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
        hamburger.classList.toggle('active');
    });

    // Close menu when a link is clicked
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.style.display = 'none';
            hamburger.classList.remove('active');
        });
    });
}

// Scroll animation for elements
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeIn 0.6s ease-out forwards';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe cards for animation
document.querySelectorAll('.news-card, .player-card, .event-card, .program-card').forEach(card => {
    observer.observe(card);
});

// Search functionality (optional)
function searchNews(keyword) {
    const newsCards = document.querySelectorAll('.news-card');
    newsCards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(keyword.toLowerCase())) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Update nav links based on scroll position
window.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('.section');
    const navLinks = document.querySelectorAll('.nav-link');

    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
});

// Live score update simulation (optional feature)
function updateLiveScore() {
    const liveStatus = document.querySelectorAll('.match-status');
    liveStatus.forEach(status => {
        if (status.textContent === 'LIVE') {
            // Simulate live score updates
            const match = status.closest('.match');
            const teams = match.querySelectorAll('.team-score');
            const randomTeam = Math.random() > 0.5 ? 0 : 1;
            const currentScore = parseInt(teams[randomTeam].textContent);
            // Uncomment to enable live updates
            // teams[randomTeam].textContent = currentScore + 1;
        }
    });
}

// Call live score update every 30 seconds (optional)
// setInterval(updateLiveScore, 30000);

// Gallery lightbox (optional enhancement)
function addGalleryLightbox() {
    const galleryImages = document.querySelectorAll('.gallery-grid img');
    
    galleryImages.forEach(img => {
        img.addEventListener('click', () => {
            // Create lightbox
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            lightbox.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
            `;

            const lightboxImg = document.createElement('img');
            lightboxImg.src = img.src;
            lightboxImg.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                border-radius: 8px;
            `;

            const closeBtn = document.createElement('button');
            closeBtn.textContent = '✕';
            closeBtn.style.cssText = `
                position: absolute;
                top: 20px;
                right: 20px;
                background: none;
                border: none;
                color: white;
                font-size: 2rem;
                cursor: pointer;
            `;

            lightbox.appendChild(lightboxImg);
            lightbox.appendChild(closeBtn);
            document.body.appendChild(lightbox);

            closeBtn.addEventListener('click', () => {
                lightbox.remove();
            });

            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) {
                    lightbox.remove();
                }
            });
        });
    });
}

// Initialize gallery lightbox on load
document.addEventListener('DOMContentLoaded', addGalleryLightbox);

// Utility function to format date
function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString(undefined, options);
}

// Export data function (for admin use)
function exportRegistrations() {
    const registrations = JSON.parse(localStorage.getItem('registrations')) || [];
    if (registrations.length === 0) {
        alert('No registrations found');
        return;
    }

    const csvContent = 'data:text/csv;charset=utf-8,' + 
        ['Full Name', 'Email', 'Phone', 'Age', 'Position', 'Program', 'Experience', 'Date'].join(',') +
        '\n' +
        registrations.map(r => 
            `${r.fullname},${r.email},${r.phone},${r.age},${r.position},${r.program},${r.experience},${r.registrationDate}`
        ).join('\n');

    const link = document.createElement('a');
    link.setAttribute('href', encodeURI(csvContent));
    link.setAttribute('download', 'registrations.csv');
    link.click();
}

// Player statistics chart (optional)
function displayPlayerStats(playerName) {
    const stats = {
        'Ahmed Hassan': { speed: 90, shooting: 85, dribbling: 80, passing: 75, defense: 40 },
        'Karim Al-Rashid': { speed: 85, shooting: 70, dribbling: 88, passing: 92, defense: 65 },
        'Omar Ibrahim': { speed: 80, shooting: 45, dribbling: 70, passing: 80, defense: 95 },
        'Ali Mohammed': { speed: 75, shooting: 30, dribbling: 50, passing: 70, defense: 90 }
    };

    return stats[playerName] || null;
}

// Performance monitoring (optional)
function logPerformanceMetrics() {
    if (window.performance && performance.timing) {
        const perfData = performance.timing;
        const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
        console.log('Page Load Time: ' + pageLoadTime + 'ms');
    }
}

window.addEventListener('load', logPerformanceMetrics);

// Keyboard shortcuts (optional)
document.addEventListener('keydown', (e) => {
    // Press 'R' to scroll to registration
    if (e.key === 'r' || e.key === 'R') {
        scrollToSection('register');
    }
    // Press 'H' to scroll to home
    if (e.key === 'h' || e.key === 'H') {
        scrollToSection('home');
    }
});

// Print friendly styles
window.addEventListener('beforeprint', () => {
    document.body.style.backgroundColor = 'white';
});

console.log('⚽ Kings Football Academy Website Loaded Successfully!');
