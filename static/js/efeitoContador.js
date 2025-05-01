document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('descricao');
    const charCounter = document.getElementById('char-counter');
    const maxLength = 1000;
    
    updateCounter();
    
    textarea.addEventListener('input', updateCounter);
    
    function updateCounter() {
        const currentLength = textarea.value.length;
        charCounter.textContent = `${currentLength}/${maxLength}`;
        
        if (currentLength > maxLength * 0.9) { // 90% do limite muda de cor
            charCounter.style.color = '#ff6b6b';
        } else {
            charCounter.style.color = '';
        }
    }
});