document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('mainForm');
    const commentTextarea = document.getElementById('comment');
    const charCounter = document.getElementById('char-counter');
    const fileInput = document.getElementById('file');
    const fileList = document.getElementById('file-list');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const successPopup = document.getElementById('successPopup');
    let selectedFiles = [];

    // Contador de caracteres
    commentTextarea.addEventListener('input', function() {
        const count = this.value.length;
        charCounter.textContent = `${count}/1000`;
        if (count > 1000) {
            charCounter.style.color = 'red';
        } else {
            charCounter.style.color = '#666';
        }
    });

    // Manipulação de arquivos
    fileInput.addEventListener('change', function(e) {
        const newFiles = Array.from(e.target.files);

        if (selectedFiles.length + newFiles.length > 4) {
            alert('Você pode anexar no máximo 4 imagens.');
            return;
        }

        newFiles.forEach(file => {
            if (file.size > 5 * 1024 * 1024) {
                alert(`O arquivo ${file.name} excede o limite de 5MB.`);
                return;
            }
            selectedFiles.push(file);
            addFileToList(file);
        });

        fileInput.value = '';
    });

    function addFileToList(file) {
        const fileItem = document.createElement('div');
        fileItem.className = 'file-item';

        const fileName = document.createElement('span');
        fileName.textContent = file.name;

        const removeButton = document.createElement('button');
        removeButton.className = 'remove-file';
        removeButton.textContent = 'Remover';
        removeButton.onclick = function() {
            selectedFiles = selectedFiles.filter(f => f !== file);
            fileItem.remove();
        };

        fileItem.appendChild(fileName);
        fileItem.appendChild(removeButton);
        fileList.appendChild(fileItem);
    }

    // Submissão do formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        loadingOverlay.style.display = 'flex';

        const formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('comment', commentTextarea.value);

        selectedFiles.forEach(file => {
            formData.append('file', file);
        });

        fetch('/', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            loadingOverlay.style.display = 'none';
            if (data.status === 'success') {
                successPopup.style.display = 'block';
                form.reset();
                fileList.innerHTML = '';
                selectedFiles = [];
                charCounter.textContent = '0/1000';
                setTimeout(() => {
                    successPopup.style.display = 'none';
                }, 2000);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            loadingOverlay.style.display = 'none';
            alert('Erro ao enviar formulário: ' + error);
        });
    });
});
