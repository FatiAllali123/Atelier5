                                                             ✨   Rapport  Atelier 5 : 


👍  Exercice 1 :

     ✔ 1.  Récupération des données d'utilisateur :
Lorsqu'un utilisateur clique sur "Voir Profil", les données de l'utilisateur sont récupérées a l’aide une fonction asynchrone (recupererDonneesUtilisateur). Cette fonction simule un appel avec setTimeout(), pour un délai de 3 secondes avant de retourner les données.	Pendant ce délai, un message de chargement ("Infos en cours de   téléchargement...") est affiché.
     ✔ 2.  Affichage du Profil :
Une fois les données de l'utilisateur récupérées , ils  sont affichées à l'écran. 

     ✔3.  Récupération des Commandes :
Après l'affichage du profil, un autre processus asynchrone commence pour récupérer les commandes de l'utilisateur Les commandes sont en cours de téléchargement. Un autre message de chargement ("...") est affiché pendant ce processus. Les commandes sont ensuite présentées dans un tableau, une fois que les données ont été récupérées.


👍Exercice 2 :

 ✔ Création de l’API : Définition d’une route et d’un contrôleur pour gérer l’upload de fichiers.
 ✔ Envoi des fichiers : On a Utilisatisé  fetch pour envoyer une requête POST à l’API Laravel.
 ✔ Récupération et affichage : Apres , on  a l'Envoi d’une requête GET pour récupérer les fichiers et mise à jour dynamique de l’interface.
 ✔ Gestion asynchrone : Utilisation des Promises pour assurer un affichage fluide des fichiers téléchargés.

   

👍Exericice 3:

   ✔ 1)	Développement  des fonctions CRUD dans le contrôleur : 
•	On a fait  les méthodes CRUD (Create, Read, Update, Delete) dans le RoomController afin de gérer les données des salles.
   ✔2)	les appels API avec fetch:
•	On a fetch  pour interagir avec l'API Laravel. L'interface frontend permet maintenant de récupérer, ajouter, modifier et supprimer des salles.
 ✔3)	Interface utilisateur:
•	On a une interface qui affiche les salles disponibles et permet de gérer celles-ci via des formulaires interactifs pour l'ajout, la modification et la suppression.


👍   Exercice 4 :
 
 ✨Pusher et Laravel WebSockets

   ✔ 1. Fichier .env :
Dans ce fichier, on a définit es informations de connexion à Pusher :
•	PUSHER_APP_ID=your-app-id
•	PUSHER_APP_KEY=your-app-key
•	PUSHER_APP_SECRET=your-app-secret
•	PUSHER_APP_CLUSTER=mt1
•	PUSHER_HOST=127.0.0.1
•	PUSHER_PORT=6001
•	PUSHER_SCHEME=http


    ✔2. Fichier config/broadcasting.php :
Ici, on a configuré  Pusher pour qu’il soit utilisé comme driver de diffusion (broadcasting) :
     
     
     'pusher' => [
            'driver' => 'pusher',
            'key' => env('1b2b74186fa29af2e797'),
            'secret' => env('546bcbe8844c7e55fef7'),
            'app_id' => env('1964227'),
            'options' => [
                'cluster' => env('eu'),
                'host' => env('PUSHER_HOST', '127.0.0.1'),
                'port' => env('PUSHER_PORT', 6001),
                'scheme' => env('PUSHER_SCHEME', 'http'),
                'encrypted' => false,
                'useTLS' => env('true') === 'https',
            ],
        ],



     ✨    Implémentation des WebSockets et Pusher
✔
Gestion des événements :
Afin de suivre les changements de stock, on a  définit un événement qui se déclenche à chaque ajout, modification ou suppression d'un stock. Cela permet de transmettre ces mises à jour en temps réel.

✔ Gestion des actions dans le StockController    :
Dans le contrôleur dédié aux stocks  , on  envoyie  ces événements à Pusher chaque fois qu'une action de gestion (ajout, mise à jour, suppression) est réalisée sur un stock. Cela permet d'assurer que les modifications se propagent instantanément aux utilisateurs qui suivent ces données.

✔Affichage  ( Highcharts  ) 
•	  On affiche les stocks sous forme de graphique avec Highcharts.
•	  On écoute les événements via Pusher et on met à jour le graphique en temps réel dès qu'un événement est déclenché.


