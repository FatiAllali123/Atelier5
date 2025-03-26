<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Salles</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color: #e74c3c;
            --background-color: #f4f6f7;
            --text-color: #2c3e50;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-group {
            display: flex;
            margin-bottom: 25px;
            gap: 10px;
        }

        input {
            flex-grow: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        button {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        #createRoomForm button {
            background-color: var(--primary-color);
            color: white;
        }

        #createRoomForm button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .room-item {
            background-color: white;
            padding: 15px;
            border-bottom: 1px solid #ecf0f1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .room-item:hover {
            background-color: #f8f9fa;
        }

        .delete-btn {
            background-color: var(--danger-color);
            color: white;
        }

        .delete-btn:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }

        .edit-btn {
            background-color: var(--secondary-color);
            color: white;
            margin-right: 10px;
        }

        .edit-btn:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion des Salles</h1>
        
        <!-- Formulaire de création -->
        <form id="createRoomForm" class="form-group">
            <input type="text" id="nom" placeholder="Nom de la salle" required>
            <input type="number" id="capacity" placeholder="Capacité" required min="1">
            <button type="submit">Ajouter Salle</button>
        </form>

        <!-- Liste des salles -->
        <div id="roomList"></div>
    </div>
    <script>
        // All previous JavaScript remains the same
        async function createRoom(name, capacity) {
            try {
                const response = await fetch('/rooms', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({ name, capacity })
                });
                if (!response.ok) throw new Error('Erreur lors de la création');
                fetchRooms();
            } catch (error) {
                console.error('Erreur création:', error);
                alert('Erreur lors de la creation de la salle');
            }
        }

        async function fetchRooms() {
            try {
                const response = await fetch('/rooms');
                if (!response.ok) throw new Error('Erreur lors de la recuperation');
                const rooms = await response.json();
                
                const roomList = document.getElementById('roomList');
                roomList.innerHTML = rooms.map(room => `
                    <div class="room-item">
                        <span>${room.name} (Capacité: ${room.capacity})</span>
                        <div>
                            <button class="edit-btn" onclick="editRoom(${room.id}, '${room.name}', ${room.capacity})">Modifier</button>
                            <button class="delete-btn" onclick="deleteRoom(${room.id})">Supprimer</button>
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Erreur fetch rooms:', error);
                alert('Erreur lors de la recuperation des salles');
            }
        }

        async function updateRoom(id, name, capacity) {
            try {
                const response = await fetch(`/rooms/${id}`, {
                    method: 'PUT',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({ name, capacity })
                });
                if (!response.ok) throw new Error('Erreur lors de la mise a jour');
                fetchRooms();
            } catch (error) {
                console.error('Erreur mise à jour:', error);
                alert('Erreur lors de la mise a jour de la salle');
            }
        }

        async function deleteRoom(id) {
            if (confirm('Voulez-vous supprimer cette salle ?')) {
                try {
                    const response = await fetch(`/rooms/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        }
                    });
                    if (!response.ok) throw new Error('Erreur lors de la suppression');
                    fetchRooms(); 
                } catch (error) {
                    console.error('Erreur suppression:', error);
                    alert('Erreur lors de la suppression de la salle');
                }
            }
        }

        document.getElementById('createRoomForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const name = document.getElementById('nom').value;
            const capacity = parseInt(document.getElementById('capacity').value);
            createRoom(name, capacity);
            e.target.reset(); 
        });

        function editRoom(id, currentName, currentCapacity) {
            const name = prompt('Nouveau nom:', currentName);
            const capacity = parseInt(prompt('Nouvelle capacité:', currentCapacity));
            if (name && !isNaN(capacity) && capacity > 0) {
                updateRoom(id, name, capacity);
            }
        }

        fetchRooms();
    </script>
</body>
</html>