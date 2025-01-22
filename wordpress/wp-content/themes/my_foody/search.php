<?php
/*
 * Search Page
 * Description: Ce fichier gère la logique de la page des résultats de recherche, y compris la gestion des filtres, des taxonomies, et des résultats des recettes.
 */

// Récupère le numéro de la page actuelle pour la pagination
global $paged;
if (!isset($paged) || !$paged) {
    $paged = 1; // Définit la première page par défaut si aucune valeur n'est définie
}

$context = Timber::context();

// Récupère la valeur de la recherche depuis l'URL (si elle existe)
$context['search_query'] = get_query_var("s");

// Charge la page actuelle dans le contexte (nécessaire pour Twig)
$context['current_page'] = new Timber\Post();

// Récupère la valeur du filtre de temps total depuis l'URL (via les variables de requête)
$context['total_time_filter'] = get_query_var('total_time') ? intval(get_query_var('total_time')) : NULL;

// Initialise un tableau pour les paramètres de la requête de filtre (taxonomies)
$query_params = [];
$query_terms = ["category", "menu_types", "diet"]; // Taxonomies possibles pour les filtres

// Parcours chaque taxonomie et vérifie si elle est présente dans l'URL
foreach ($query_terms as $query_term) {
    if (get_query_var($query_term)) {
        $query_params[] = [
            "taxonomy" => $query_term,
            "slug" => get_query_var($query_term), // Le slug de la taxonomie est récupéré
        ];
    }
}

// Ajoute les termes filtrés au contexte Timber, afin qu'ils soient accessibles dans le template
foreach ($query_params as $query_param) {
  $context["terms"][] = new Timber\Term($query_param["slug"], $query_param["taxonomy"]);
}

// Récupère les recettes filtrées en fonction des paramètres (taxonomies et temps total)
$context['recipes'] = get_recipes($query_params, $paged, $context);

// Récupère tous les termes disponibles pour les taxonomies, afin de pouvoir afficher les filtres dans le template
$context["categories"] = Timber::get_terms(['taxonomy' => 'category']);
$context["menu_types"] = Timber::get_terms(['taxonomy' => 'menu_types']);
$context["diets"] = Timber::get_terms(['taxonomy' => 'diet']);

// Marque les termes comme "actifs" dans le contexte si ces termes ont été sélectionnés dans la requête
foreach ($context["categories"] as $term) {
  if (in_array($term->slug, array_column($query_params, "slug"))) {
      $term->active = true; // Marque ce terme comme sélectionné
  }
}

foreach ($context["menu_types"] as $term) {
  if (in_array($term->slug, array_column($query_params, "slug"))) {
      $term->active = true;
  }
}

foreach ($context["diets"] as $term) {
  if (in_array($term->slug, array_column($query_params, "slug"))) {
      $term->active = true;
  }
}

// Récupère les tags populaires, en mélangeant les termes disponibles et en affichant une sélection aléatoire
$context["tags"] = get_X_random_terms(array_merge($context["categories"], $context["menu_types"], $context["diets"]), 9);

// Rendu du template avec le contexte mis à jour
Timber::render('templates/search.twig', $context);

/**
 * Fonction pour ajouter des filtres personnalisés à la requête SQL de WordPress,
 * permettant de filtrer les recettes en fonction du temps total (préparation + cuisson).
 *
 * @param array $clauses Les clauses SQL de la requête.
 * @param object $query L'objet WP_Query.
 * @return array Les clauses SQL modifiées.
 */
function custom_posts_clauses_filter($clauses, $query) {
  global $wpdb;

  // Vérifie si un filtre sur le temps total est défini dans la requête
  $total_time_filter = $query->get('total_time_filter');
  if (!$total_time_filter) {
      unset($args['total_time_filter']); // Supprime le filtre si aucun temps total n'est défini
  } else {
      // Ajoute une jointure à la requête SQL pour inclure les champs 'prep_time' et 'baking_time'
      $clauses['join'] .= "
          LEFT JOIN {$wpdb->postmeta} AS prep_time_meta 
              ON ({$wpdb->posts}.ID = prep_time_meta.post_id AND prep_time_meta.meta_key = 'prep_time')
          LEFT JOIN {$wpdb->postmeta} AS baking_time_meta 
              ON ({$wpdb->posts}.ID = baking_time_meta.post_id AND baking_time_meta.meta_key = 'baking_time')
      ";

      // Ajoute une condition pour filtrer les résultats en fonction du temps total (somme des champs 'prep_time' et 'baking_time')
      $clauses['where'] .= $wpdb->prepare("
          AND (
              (prep_time_meta.meta_value + baking_time_meta.meta_value) <= %d
          )
      ", $total_time_filter);
  }

  return $clauses; // Retourne les clauses SQL modifiées
}

/**
 * Fonction qui récupère les recettes en fonction des filtres de taxonomies et du temps total.
 *
 * @param array $query_params Les paramètres de la requête pour les taxonomies.
 * @param int $paged Le numéro de la page courante pour la pagination.
 * @param array $context Le contexte Timber (incluant des informations de filtre).
 * @return Timber\PostQuery Les recettes correspondantes à la requête.
 */
function get_recipes($query_params, $paged, $context) {
  $tax_query = [];
  
  // Crée les conditions de filtrage par taxonomie (catégorie, menu_type, diet)
  foreach ($query_params as $query_param) {
      $context["terms"][] = new Timber\Term($query_param["slug"], $query_param["taxonomy"]);
      $tax_query[] = [
          "taxonomy" => $query_param["taxonomy"],
          "field" => "slug",
          "terms" => $query_param["slug"],
      ];
  }

  $meta_query = []; // Initialisation du tableau pour les conditions de métadonnées

  // Si un filtre sur le temps total est défini, ajoute les conditions nécessaires
  if ($context['total_time_filter']) {
      // Applique le filtre personnalisé pour modifier les clauses SQL
      add_filter('posts_clauses', 'custom_posts_clauses_filter', 10, 2);

      // Ajoute des conditions pour vérifier l'existence des champs 'prep_time' et 'baking_time'
      $meta_query = ['relation' => 'AND'];
      $meta_query[] = [
          'key'     => 'prep_time',
          'compare' => 'EXISTS',
          'type'    => 'NUMERIC',
      ];
      $meta_query[] = [
          'key'     => 'baking_time',
          'compare' => 'EXISTS',
          'type'    => 'NUMERIC',
      ];
  }

  // Paramètres de la requête WP_Query
  $args = [
      'post_type'      => 'post',
      'orderby'        => 'date',
      'posts_per_page' => get_option('posts_per_page'),
      'paged'          => $paged,
      'tax_query'      => $tax_query,
      'meta_query'     => $meta_query,
      'total_time_filter' => $context['total_time_filter'], // Filtre sur le temps total
      's'              => $context['search_query'], // Filtre par texte de recherche
  ];

  // Exécution de la requête avec Timber
  $result_query = new Timber\PostQuery($args);

  // Retire le filtre après la requête pour éviter tout effet de bord
  remove_filter('posts_clauses', 'custom_posts_clauses_filter');

  return $result_query; // Retourne les recettes récupérées
}
