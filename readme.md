# **Gestionnaire de Projets (OOP)**

**Auteur du Brief** : Iliass RAIHANI  
**Author:** Oumaima Ait said.
**Créé le** : 30/12/24

Cette plateforme vise à simplifier la gestion et la collaboration des équipes en offrant un espace où les utilisateurs peuvent créer, suivre et gérer leurs projets efficacement. Ce projet est développé en **PHP 8** avec une approche de **Programmation Orientée Objet** (POO) et utilise **PDO** pour interagir avec la base de données.

---

## **Table des Matières**

1. [Contexte du Projet](#contexte-du-projet)
2. [Technologies Requises](#HTML-#tailwindCss-#php,)
3. [Cas D'utulisation](#)
4. [Diagramme de classe](#)

---
## Links

- **GitHub Repository :** [View on GitHub](https://github.com/Youcode-Classe-E-2024-2025/oumaima_aitsaid_project.git)


## **Contexte du Projet**

Le but de ce projet est de fournir une interface intuitive et efficace pour les membres des équipes et un tableau de bord pour les chefs de projet. Cela permettra une gestion optimale des tâches, des membres et des échéances. L’objectif est de faciliter la collaboration, le suivi des progrès des projets, et d’assurer que les objectifs soient atteints dans les délais.

---

## **Technologies Requises**

- **Langage** : PHP 8 (Programmation Orientée Objet)
- **Base de données** : MySQL avec PDO comme driver pour la gestion des données.
- **Framework CSS** : Tailwind CSS pour un design responsive.

---

## **User Stories**

### **En tant que Chef de Projet** :

- **Gestion des Projets** :
  - Créer, modifier et supprimer des projets pour structurer le travail de l’équipe.
- **Gestion des Tâches** :
  - Assigner des tâches aux membres pour une meilleure répartition des responsabilités.
  - Catégoriser et taguer les tâches pour une meilleure organisation.
- **Suivi de l’avancement** :
  - Suivre l'état des tâches pour assurer que le projet avance comme prévu.

### **En tant que Membre de l’Équipe** :

- **Inscription et Connexion** :
  - Créer un compte avec un nom, un e-mail et un mot de passe pour accéder à mon compte.
  - Connexion sécurisée pour consulter et mettre à jour mes tâches.
- **Participation aux Projets** :
  - Accéder aux projets auxquels je suis assigné.
  - Mettre à jour le statut de mes tâches pour informer l’équipe.

### **En tant qu’Utilisateur Invité** :

- **Visualisation des Projets** :
  - Consulter les projets publics pour découvrir les activités des équipes.
  - S’inscrire ou créer un projet si je souhaite participer ou démarrer un projet.

---

## **Livrables et Critères de Performance**

### **Livrables** :

- Lien vers le repository GitHub du projet (code source + script SQL).
- Gestion des tâches sur un Scrum Board avec toutes les User Stories.
- Diagrammes UML :
  - Diagramme de classes.
  - Diagramme de cas d’utilisation.

### **Critères de Performance** :

1. **Planification des Tâches** : Utilisation d’un outil comme Jira pour planifier et suivre les tâches.
2. **Elaboration des User Stories** : Rédaction claire et précise des besoins.
3. **Commits Journaliers** : Commits réguliers sur GitHub pour assurer un bon suivi des modifications.
4. **Design Responsive** : Interface adaptée à toutes les tailles d’écrans grâce à Tailwind CSS.
5. **Validation des Formulaires** :
   - **Frontend** : Validation HTML5 et JavaScript.
   - **Backend** : Sécurisation contre XSS et CSRF.
6. **Structure du Projet** : Séparation claire entre la logique métier et l’architecture.
7. **Sécurité** :
   - Prévention des injections SQL avec des requêtes préparées.
   - Protection contre le XSS en échappant les données affichées.
   - Gestion des erreurs (ex. page 404).

---

## **Planification et Modalités d'Évaluation**

### **Durée et Dates** :

- **Version 1** :  
  - Lancement du brief : 30/12/2024 à 09:00  
  - Soumission : 03/01/2025 avant 23:59
- **Version 2** :  
  - Lancement du brief : 06/01/2025 à 09:00  
  - Soumission : 10/01/2025 avant 23:59

### **Modalités d'Évaluation** :

- **30 minutes** : Quiz avec mise en situation.
- **15 minutes** : Démonstration du projet et code review.

---

## **Installation et Configuration**

### Prérequis :

- PHP 8.0+
- MySQL
- Composer
- Laragon (ou un environnement local similaire)

### Étapes d'Installation :

1. **Cloner le Projet** :

   -git clone https://github.com/Youcode-Classe-E-2024-2025/oumaima_aitsaid_project.git

2. **Placer le projet dans le dossier Laragon** :
   - Cliquez sur le bouton **Root** dans Laragon pour ouvrir le dossier `www` (par défaut, `C:\laragon\www`).
   - Le chemin de votre projet devrait être `C:\laragon\www\OOP`.

3. **Configurer la base de données** :
   - Faites un clic droit sur **Laragon**, puis allez dans **Tools** > **Quick Add** et téléchargez **phpMyAdmin** et **MySQL**.
   - Ouvrir **phpMyAdmin** via Laragon :
     - Dans Laragon, cliquez sur le bouton **Database** pour accéder à phpMyAdmin (username = `root` et mode de passe est vide).
     - La base de données est automatiquement créez ou vous pouvez Créez une base de données `gestionnaire_de_projets` disponible dans le dossier( `sql/create.slq`).


4. **Installer les dépendances Node.js** :
   - Ouvrez un terminal dans le dossier du projet cloné.
   - Exécutez :  `npm install` or `npm i`

5. **Configurer Laragon pour le serveur local** :
   - Lancez **Laragon** et démarrez les services **Apache** et **MySQL**,en Clickant sur **Start All**.


6. **Exécuter le projet** :
   - Une fois les services lancés dans Laragon, cliquez sur le bouton **Web** pour accéder à `http://localhost/OOP` dans votre navigateur.