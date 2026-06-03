# CityAlert SN - Système de Gestion des Incidents Urbains (Dakar)

## 📌 Présentation du Projet

**CityAlert SN** est une plateforme numérique de proximité conçue pour dématérialiser et optimiser le canal de signalement et de traitement des anomalies sur la voie publique (dégradations de la voirie, pannes d'éclairage public, dépôts sauvages d'ordures, fuites d'eau).

Ce système interconnecte directement les citoyens de la métropole de Dakar avec les services techniques de la municipalité pour garantir une gestion transparente, réactive et performante des infrastructures urbaines.

---

## 👥 Équipe de Développement (ISM - L2 IAGE 2025-2026)

Projet de fin d'année réalisé sous la direction de **M. Cheikh Tidiane Ndiaye** :

- **Mbene Diop** : Modélisation UML, Conception de la Base de Données RelRelationnelle (SQL) & Documentation.
- **Ndeye Coumba Diack Ndiaye** : Gestion des Vues (HTML/PHP) & Intégration des interfaces.
- **Sokhna Astou Dia** : Design d'Interface & Expérience Utilisateur (UI/UX - Thème Sombre).
- **Ousmane Diallo** : Architecture Backend (MVC Native PHP), Routage Applicatif & Sécurité.

---

## 🛠️ Architecture & Technologies

L'application est entièrement développée sans framework externe afin de maîtriser le cycle de vie complet des requêtes HTTP :

- **Architecture :** Architecture MVC Native (Modèle-Vue-Contrôleur).
- **Backend :** PHP 8.x (Programmation Orientée Objet avec encapsulation stricte, héritage et polymorphisme).
- **Frontend :** HTML5, CSS3 (Premium Dark Theme unifié, responsive design).
- **Base de données :** MySQL (Contraintes d'intégrité référentielle fortes).
- **Serveur :** Apache (Réécriture d'URL via `.htaccess`).

---

## 📐 Modélisation Orientée Objet (POO)

Le cœur de l'application s'appuie sur des concepts fondamentaux de la POO :

1.  **Encapsulation :** Protection absolue des propriétés métiers via des attributs privés et des accesseurs (`getters` / `setters`).
2.  **Héritage & Abstraction :** Classe mère `abstract class Utilisateur` étendue par les sous-classes spécialisées : `Citoyen`, `AgentMunicipal` et `Administrateur`.
3.  **Polymorphisme :** Implémentation dynamique de la méthode `afficherTableauDeBord()` selon le rôle de l'utilisateur connecté.
4.  **Flexibilité :** Découplage des notifications via l'interface `NotificationInterface`.

---

## 🚀 Fonctionnalités Clés

- **Espace Citoyen :** Inscription, authentification sécurisée, dépôt de signalements détaillés avec catégorie et adresse, suivi du cycle de vie de l'incident (Nouveau, En cours, Résolu) et fil de discussion asynchrone.
- **Espace Agent Municipal :** Tableau de bord de supervision, tri par priorité, prise en charge de dossiers, rédaction de notes techniques de résolution et clôture des tickets.
- **Panneau Administrateur :** Modération globale, gestion des utilisateurs, configuration et ajout de nouvelles catégories d'incidents.

---

## ⚙️ Installation Globale en Local

1. Cloner le projet dans le répertoire de votre serveur local (ex: `wamp64/www/`).
2. Importer le fichier `schema.sql` dans votre gestionnaire de base de données (phpMyAdmin).
3. Configurer les accès à la base de données dans le fichier `app/Config/Database.php`.
4. Accéder à l'application via votre navigateur à l'adresse `http://localhost/cityalert/public/`.
