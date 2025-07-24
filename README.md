# Bastien-Webapp-V2
=============================================

Description du Projet
---------------------

Ce projet vise à développer une **Progressive Web App (PWA)** robuste et dynamique, permettant aux utilisateurs de gérer du contenu structuré autour de différents thèmes. L'application inclura un système d'authentification utilisateur et une gestion fine des accès aux thèmes, avec une API RESTful pour faciliter les interactions.

Technologies Utilisées
----------------------

*   **Frontend**: HTML5, CSS3, JavaScript
    
*   **Backend**: PHP (version **8.3**) avec le framework **Symfony (dernière version stable)**
    
*   **API**: **Symfony API Platform** pour la création d'une API RESTful
    
*   **Base de Données**: **MySQL**
    

Fonctionnalités Principales
---------------------------

1.  **Authentification Utilisateur**:
    
    *   Page de connexion sécurisée.
        
    *   Fonctionnalité de création de compte utilisateur.
        
    *   Gestion des sessions utilisateur via l'API.
        
2.  **Gestion des Thèmes**:
    
    *   Possibilité de définir plusieurs thèmes (ex: "Sport", "Cuisine", "Musique", etc.).
        
    *   Chaque utilisateur peut être autorisé à accéder à un ou plusieurs thèmes spécifiques.
        
    *   L'interface utilisateur doit s'adapter pour afficher uniquement les thèmes autorisés pour l'utilisateur connecté, en interagissant avec l'API.
        
3.  **Thème Spécifique : "Sport"**: Ce thème inclura les entités et relations suivantes :
    
    *   **Programme**: Représente un plan d'entraînement global.
        
    *   **Séance**: Une séance est liée à un `Programme` et contient un ensemble d'exercices.
        
    *   **Exercice**: Un exercice peut être inclus dans plusieurs `Séances`.
        
    *   **Entraînement**: Représente une instance d'exécution d'une séance ou d'un programme.
        

Architecture de la Base de Données (MySQL)
------------------------------------------

La base de données MySQL stockera toutes les informations relatives aux utilisateurs, aux thèmes et aux données spécifiques à chaque thème. Les noms de colonnes seront uniformisés pour plus de clarté.

### Structure de Données Clé (Exemple pour le Thème "Sport")

*   **utilisateurs**:
    
    *   `id` (PK)
        
    *   `nom_utilisateur`
        
    *   `email`
        
    *   `mot_de_passe_hache`
        
    *   `date_creation`
        
    *   `date_mise_a_jour`
        
*   **themes**:
    
    *   `id` (PK)
        
    *   `nom_theme` (ex: "Sport", "Cuisine")
        
    *   `description_theme`
        
*   **utilisateur\_themes**: (Table de liaison Many-to-Many pour les autorisations)
    
    *   `utilisateur_id` (PK, FK vers `utilisateurs.id`)
        
    *   `theme_id` (PK, FK vers `themes.id`)
        
*   **programmes**:
    
    *   `id` (PK)
        
    *   `nom_programme`
        
    *   `description_programme`
        
    *   `utilisateur_id` (FK vers `utilisateurs.id` - lien vers l'utilisateur propriétaire)
        
    *   `date_creation`
        
    *   `date_mise_a_jour`
        
*   **seances**:
    
    *   `id` (PK)
        
    *   `nom_seance`
        
    *   `description_seance`
        
    *   `programme_id` (FK vers `programmes.id`)
        
    *   `date_creation`
        
    *   `date_mise_a_jour`
        
*   **exercices**:
    
    *   `id` (PK)
        
    *   `nom_exercice`
        
    *   `description_exercice`
        
    *   `type_exercice` (ex: "force", "cardio")
        
    *   `date_creation`
        
    *   `date_mise_a_jour`
        
*   **seance\_exercices**: (Table de liaison Many-to-Many entre `seances` et `exercices`)
    
    *   `seance_id` (PK, FK vers `seances.id`)
        
    *   `exercice_id` (PK, FK vers `exercices.id`)
        
    *   `ordre_affichage` (pour définir l'ordre des exercices dans une séance)
        
    *   `repetitions` (spécifique à cette liaison)
        
    *   `series` (spécifique à cette liaison)
        
    *   `duree_minutes` (spécifique à cette liaison)
        
*   **entrainements**:
    
    *   `id` (PK)
        
    *   `date_entrainement`
        
    *   `duree_minutes`
        
    *   `notes_entrainement`
        
    *   `seance_id` (FK vers `seances.id` - si l'entraînement est basé sur une séance spécifique)
        
    *   `programme_id` (FK vers `programmes.id` - si l'entraînement est basé sur un programme entier)
        
    *   `utilisateur_id` (FK vers `utilisateurs.id` - l'utilisateur qui a effectué l'entraînement)
        
    *   `date_creation`
        
    *   `date_mise_a_jour`
        

Directives pour l'Agent IA
--------------------------

L'agent IA est invité à :

1.  **Mettre en place l'environnement Symfony**:
    
    *   Création du projet Symfony avec la dernière version stable.
        
    *   Configuration de PHP 8.3.
        
    *   Configuration de la base de données MySQL.
        
    *   Installation et configuration de **Symfony API Platform**.
        
2.  **Développer le système d'authentification**:
    
    *   Implémentation des routes d'API pour la connexion, l'enregistrement, la déconnexion et la gestion des utilisateurs.
        
    *   Utiliser les composants de sécurité de Symfony et les fonctionnalités d'authentification d'API Platform (JWT ou autre mécanisme approprié).
        
3.  **Modéliser les entités**:
    
    *   Créer les entités Doctrine (Symfony ORM) pour `Utilisateur`, `Theme`, `Programme`, `Seance`, `Exercice` et `Entrainement` avec leurs relations appropriées (One-to-Many, Many-to-Many).
        
    *   Générer les entités de liaison (`UtilisateurTheme`, `SeanceExercice`) pour les relations Many-to-Many.
        
    *   Définir les attributs API Platform pour exposer ces entités via l'API RESTful.
        
4.  **Développer les interfaces utilisateur (HTML/CSS/JS)**:
    
    *   Pages de connexion et d'enregistrement interagissant avec l'API.
        
    *   Tableau de bord utilisateur affichant les thèmes autorisés, récupérés via l'API.
        
    *   Interfaces pour la gestion des programmes, séances, exercices et entraînements pour le thème "Sport", toutes interagissant avec l'API.
        
    *   Assurer que l'application est une PWA (manifest.json, service worker pour le cache et les fonctionnalités hors ligne de base).
        
5.  **Implémenter la logique métier**:
    
    *   Développer les opérations CRUD via l'API Platform pour toutes les entités.
        
    *   Implémenter la logique de vérification des autorisations d'accès aux thèmes pour chaque utilisateur via l'API.
        
    *   Mettre en place la validation des données côté serveur (via Symfony et API Platform) et côté client.
        

Prochaines Étapes
-----------------

*   Initialisation du projet Symfony avec PHP 8.3 et configuration de MySQL.
    
*   Installation et configuration de Symfony API Platform.
    
*   Création des entités Doctrine et des migrations de base de données pour toutes les tables.
    
*   Développement des endpoints API pour l'authentification et les entités principales.
    
*   Mise en place de l'architecture frontend pour interagir avec l'API.
