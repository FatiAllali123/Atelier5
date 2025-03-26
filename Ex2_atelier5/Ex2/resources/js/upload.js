document.addEventListener('DOMContentLoaded', () => {
    const uploadForm = document.getElementById('uploadForm');
    const fileListContainer = document.getElementById('fileList');

    // Fonction d'upload
    uploadForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0];

        if (!file) return alert('Veuillez sélectionner un fichier.');

        const formData = new FormData();
        formData.append('file', file);

        try {
            const response = await fetch('http://localhost:8000/file/upload', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) throw new Error('Erreur serveur');
            
            const data = await response.json();
            alert(data.message);
            loadFiles();
        } catch (error) {
            console.error('Erreur:', error);
            alert('Échec du téléversement: ' + error.message);
        }
    });

    // Fonction pour charger les fichiers
    async function loadFiles() {
        try {
            const response = await fetch('http://localhost:8000/file/');
            if (!response.ok) throw new Error('Erreur serveur');
            
            const files = await response.json();
            fileListContainer.innerHTML = '';

            files.forEach(file => {
                const fileItem = document.createElement('li');
                fileItem.innerHTML = `
                    <a href="/file/download/${file.id}" download>${file.name}</a>
                    <button onclick="deleteFile(${file.id})">Supprimer</button>
                `;
                fileListContainer.appendChild(fileItem);
            });
        } catch (error) {
            console.error('Erreur:', error);
            fileListContainer.innerHTML = '<li>Erreur de chargement</li>';
        }
    }

    // Fonction de suppression
    window.deleteFile = async (id) => {
        if (!confirm('Supprimer ce fichier ?')) return;
        
        try {
            const response = await fetch(`/file/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) throw new Error('Échec de suppression');
            loadFiles();
        } catch (error) {
            console.error('Erreur:', error);
            alert('Échec de suppression: ' + error.message);
        }
    };

    loadFiles();
});