<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

// Initialise le contexte Timber
$context = Timber::context();

// Charge la page actuelle dans le contexte (utile pour accéder aux informations de la page d'accueil)
$context['current_page'] = new Timber\Post();

// Récupère les 4 dernières recettes publiées
$context['latest_recipes'] = Timber::get_posts([
  'post_type' => 'post', // Type de contenu (ici les articles)
  'posts_per_page' => 4, // Limite le nombre de résultats à 4
]);

// Récupère les termes associés à la taxonomie `menu_types`
$menu_types_terms = Timber::get_terms([
  'taxonomy' => 'menu_types', // Nom de la taxonomie
]);

// Récupère les termes associés à la taxonomie `category`
$category_terms = Timber::get_terms([
  'taxonomy' => 'category', // Nom de la taxonomie
]);

// Combine les termes de `menu_types` et `category` en un seul tableau
$terms = array_merge($menu_types_terms, $category_terms);

// Sélectionne aléatoirement 3 termes parmi les termes combinés
$context["terms"] = get_X_random_terms($terms, 3);

// Récupère les termes associés à la taxonomie `diet`
$diet_terms = Timber::get_terms([
  'taxonomy' => 'diet', // Nom de la taxonomie
]);

// Combine tous les termes (menu_types, category et diet)
$all_terms = array_merge($terms, $diet_terms);

// Sélectionne aléatoirement 9 termes parmi tous les termes combinés
$context["tags"] = get_X_random_terms($all_terms, 9);

// Rend la vue Twig pour la page d'accueil
Timber::render('templates/index.twig', $context);
