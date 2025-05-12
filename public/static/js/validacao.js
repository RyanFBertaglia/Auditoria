<script>
    // Contador de caracteres
    

    // Validação de arquivos
    const fileInput = document.getElementById('imagem');
    const fileList = document.getElementById('file-list');
    const submitButton = document.getElementById('submitButton');
    const MAX_FILES = 4;
    const MAX_SIZE = 5 * 1024 * 1024; // 5 MB

    fileInput.addEventListener('change', () => {
        fileList.innerHTML = '';
        let valid = true;
        const files = Array.from(fileInput.files);

        if (files.length > MAX_FILES) {
            alert(`Você pode enviar no máximo ${MAX_FILES} imagens.`);
            valid = false;
        }

        files.forEach(file => {
            const listItem = document.createElement('div');
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            listItem.textContent = `${file.name} (${sizeMB} MB)`;
            fileList.appendChild(listItem);

            if (file.size > MAX_SIZE) {
                alert(`O arquivo ${file.name} excede o limite de 5 MB.`);
                valid = false;
            }
        });

        submitButton.disabled = !valid;
    });
    </script>