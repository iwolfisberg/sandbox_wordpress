# Sandbox WordPress

Bienvenue dans le repository **sandbox_wordpress**, conçu pour aider les élèves à découvrir et manipuler WordPress tout en apprenant à intégrer des concepts avancés comme Timber, ACF Fields block, et des extensions personnalisées. Ce projet est basé sur WordPress version 6.x.

## Objectif pédagogique

Ce repository est destiné à des élèves débutants en WordPress et PHP, avec une expérience limitée aux technologies frontend comme HTML, CSS et JavaScript. L’objectif est de leur offrir une introduction structurée et progressive au développement backend avec WordPress.

## Installation et Configuration

### Pré-requis

- Un serveur local avec PHP, MySQL et Apache/Nginx (ex. : MAMP, XAMPP).
- Un outil comme PHPMyAdmin pour gérer la base de données.

### Structure

Le dossier `foody` contient deux dossiers:

- `theme-template`: le template créé à l'aide du starterkit en HTML, CSS et JavaScript
- `wordpress`: l'installation WordPress

### Étapes d'installation

1. **Cloner le repository**

   ```bash
   git clone https://github.com/iwolfisberg/sandbox_wordpress.git
   ```

2. **Configurer la base de données**

   - Importez le fichier `wp_foody.sql.gz` dans PHPMyAdmin :
     1. Ouvrez PHPMyAdmin et créez une nouvelle base de données.
     2. Allez dans l’onglet "Importer".
     3. Sélectionnez le fichier `wp_foody.sql.gz` et démarrez l’importation.

3. **Configurer `wp-config.php`**

   - Ajustez les paramètres de connexion à la base de données **si nécessaire** :
     ```php
     define('DB_NAME', 'votre_nom_de_base');
     define('DB_USER', 'votre_utilisateur');
     define('DB_PASSWORD', 'votre_mot_de_passe');
     define('DB_HOST', 'localhost');
     ```
   - Activez le mode debug pour le développement si besoin :
     ```php
     define('WP_DEBUG', true);
     ```

4. **Accéder au site**
   Une fois configuré, ouvrez votre navigateur à l’adresse correspondant à votre serveur local pour accéder à votre site WordPress.

   Pour accéder à l'admin, il faut aller sur `http://localhost/foody/wordpress/wp-admin`.

   Pour se connecter avec le dumb de la base de données, voici les infos de connection:

   - **nom d'utilisateur**: admin
   - **mot de passe**: admin

---

## Structure du Projet

### Focus sur `wp-content`

Ce projet se concentre principalement sur le dossier `wp-content`, qui contient :

- **themes** : les thèmes WordPress, y compris le thème personnalisé.
- **plugins** : les plugins utilisés dans le projet.

### Le thème : `my_foody`

Le thème personnalisé `my_foody` est basé sur le starter theme de Timber. Voici quelques détails importants :

#### Structure du thème

- **Templates Twig avec Timber** :

  - Utilisation de Timber pour un rendu plus lisible avec Twig.
  - Les contrôleurs de Timber définissent le contexte et appellent les templates Twig via `Timber::render()`.

- **Organisation des fichiers dans `config`** :
  - Au lieu d’un seul fichier `functions.php`, la configuration est répartie dans plusieurs fichiers pour plus de lisibilité (exemple : global_settings, taxonomies, menus, etc.).

#### Création des templates

Le dossier appelé `theme-template` contient une installation du _starterkit_ utilisant **TailwindCSS**. Voici le processus pour modifier les styles :

1. Modifiez les styles dans le dossier `theme-template` comme nécessaire.
2. Lancez la commande de build pour générer les fichiers et les exporter vers le dossier `wordpress/wp-content/themes/my_foody/dist`: `npm run wp-build`.
3. Reportez les changements dans les templates correspondants de `my_foody`.

### Les extensions (plugins)

Le dossier `plugins` contient plusieurs extensions actives :

1. **Timber** (provient d'un fournisseur externe) :

   - Simplifie le développement de thèmes avec un système de templating Twig.
   - Améliore la lisibilité et la modularité du code.

2. **ACF (Advanced Custom Fields)** (provient d'un fournisseur externe) :

   - Permet d’ajouter des champs personnalisés en fonction des types de publication (ex. : champs spécifiques pour les pages ou les articles).

3. **Cache enabler** (provient d'un fournisseur externe) :

   - Extension simple et rapide pour la mise en cache de WordPress.
   - Permet d'améliorer les performances du site

4. **Simple CPT** (provient d'un fournisseur externe) :

   - Permet de créer des custom post types et custom taxonomies via l'interface admin (plutôt qu'en écrivant du code dans le fichier `functions.php`).

5. **Custom Block** (extension créé sur mesure) :
   - Un plugin personnalisé permettant d’ajouter des blocs Gutenberg sur mesure.

---

## Ressources supplémentaires

- **Documentation WordPress** : [https://developer.wordpress.org/](https://developer.wordpress.org/)
- **Timber (Twig)** : [https://timber.github.io/](https://timber.github.io/)
- **ACF** : [https://www.advancedcustomfields.com/](https://www.advancedcustomfields.com/)
- **TailwindCSS** : [https://tailwindcss.com/](https://tailwindcss.com/)

## Problèmes ou questions

Pour toute question ou assistance, n’hésitez pas à ouvrir une issue dans ce repository ou à me contacter directement. Bonne exploration !
