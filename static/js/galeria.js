// Inicializa todas as galerias
document.addEventListener('DOMContentLoaded', function() {
    const galleries = document.querySelectorAll('.gallery-container');
    galleries.forEach(gallery => {
        const id = gallery.id;
        window[`slideIndex_${id}`] = 1;
        showSlides(id, 1);
    });
});

function plusSlides(galleryId, n) {
    showSlides(galleryId, window[`slideIndex_${galleryId}`] += n);
}

function currentSlide(galleryId, n) {
    showSlides(galleryId, window[`slideIndex_${galleryId}`] = n);
}

function showSlides(galleryId, n) {
    const gallery = document.getElementById(galleryId);
    let i;
    const slides = gallery.getElementsByClassName("mySlides");
    const dots = gallery.getElementsByClassName("demo");
    const captionText = gallery.querySelector(".caption");
    
    // Verifica os limites
    if (n > slides.length) { window[`slideIndex_${galleryId}`] = 1 }
    if (n < 1) { window[`slideIndex_${galleryId}`] = slides.length }
    
    // Tira todos os slides
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    
    slides[window[`slideIndex_${galleryId}`]-1].style.display = "block";
    if (dots.length > 0) {
        dots[window[`slideIndex_${galleryId}`]-1].className += " active";
        captionText.innerHTML = dots[window[`slideIndex_${galleryId}`]-1].alt;
    }
}