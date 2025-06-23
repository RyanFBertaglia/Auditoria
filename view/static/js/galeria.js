function plusSlides(galleryId, n) {
    showSlides(galleryId, slideIndex[galleryId] += n);
}

function currentSlide(galleryId, n) {
    showSlides(galleryId, slideIndex[galleryId] = n);
}

function showSlides(galleryId, n) {
    const gallery = document.getElementById(galleryId);
    if (!gallery) return;
    
    const slides = gallery.getElementsByClassName("mySlides");
    const dots = gallery.getElementsByClassName("demo");
    const captionText = gallery.querySelector(".caption");
    
    if (n > slides.length) { slideIndex[galleryId] = 1; }
    if (n < 1) { slideIndex[galleryId] = slides.length; }
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }
    
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    
    if (slides[slideIndex[galleryId] - 1]) {
        slides[slideIndex[galleryId] - 1].classList.add("active");
        if (captionText) {
            captionText.innerHTML = `Imagem ${slideIndex[galleryId]} de ${slides.length}`;
        }
    }
    
    if (dots[slideIndex[galleryId] - 1]) {
        dots[slideIndex[galleryId] - 1].classList.add("active");
    }
}

let slideIndex = {};

document.addEventListener('DOMContentLoaded', function() {
    const galleries = document.querySelectorAll('.gallery-container');
    galleries.forEach(function(gallery) {
        const galleryId = gallery.id;
        slideIndex[galleryId] = 1;
        showSlides(galleryId, 1);
    });
});

document.addEventListener('keydown', function(e) {
    const activeGallery = document.querySelector('.gallery-container:hover');
    if (activeGallery) {
        const galleryId = activeGallery.id;
        if (e.key === 'ArrowLeft') {
            plusSlides(galleryId, -1);
        } else if (e.key === 'ArrowRight') {
            plusSlides(galleryId, 1);
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const galleries = document.querySelectorAll('.gallery-container');
    galleries.forEach(function(gallery) {
        const slides = gallery.querySelectorAll('.mySlides');
        if (slides.length <= 1) {
            const controls = gallery.querySelectorAll('.prev, .next');
            controls.forEach(control => control.style.display = 'none');
        }
    });
});

// Melhora sensibilidade do touch em mobile
if ('ontouchstart' in window) {
    document.addEventListener('touchstart', function() {}, true);
}