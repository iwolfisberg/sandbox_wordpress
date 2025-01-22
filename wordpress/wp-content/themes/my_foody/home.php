<?php
/** Contrôleur implémentant la logique pour la page de liste des recettes en fonction des paramètres de requête */

// Récupère le numéro de la page actuelle pour la pagination
global $paged;

if (!isset($paged) || !$paged) {
    $paged = 1; // Définit la première page par défaut si aucune valeur n'est définie
}

// Initialise le contexte Timber
$context = Timber::context();

// Charge la page actuelle dans le contexte
$context['current_page'] = new Timber\Post();

// Récupère la valeur du filtre de temps total depuis l'URL (via les variables de requête)
$context['total_time_filter'] = get_query_var('total_time') ? intval(get_query_var('total_time')) : NULL;

// Récupère les paramètres de la requête qui correspondent aux différentes taxonomies
$query_params = [];
$query_terms = ["category", "menu_types", "diet"]; // Les taxonomies disponibles pour le filtre
foreach ($query_terms as $query_term) {
    if (get_query_var($query_term)) {
        $query_params[] = [
            "taxonomy" => $query_term,
            "slug" => get_query_var($query_term), // Slug de la taxonomie récupéré depuis l'URL
        ];
    }
}

// Ajoute les termes filtrés au contexte pour les rendre disponibles dans le template
foreach ($query_params as $query_param) {
    $context["terms"][] = new Timber\Term($query_param["slug"], $query_param["taxonomy"]);
}

// Récupère les recettes en fonction des filtres appliqués
$context['recipes'] = get_recipes($query_params, $paged, $context['total_time_filter']);

// Récupère toutes les taxonomies pour les affichages des filtres dans le template
$context["categories"] = Timber::get_terms([
    'taxonomy' => 'category',
]);
$context["menu_types"] = Timber::get_terms([
    'taxonomy' => 'menu_types',
]);
$context["diets"] = Timber::get_terms([
    'taxonomy' => 'diet',
]);

// Marque les termes actifs en fonction des filtres appliqués
foreach ($context["categories"] as $term) {
    if (in_array($term->slug, array_column($query_params, "slug"))) {
        $term->active = true; // Indique que ce terme est actuellement sélectionné
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

// Rend le template Twig avec le contexte
Timber::render('templates/recipes.twig', $context);

// Ajoute un filtre personnalisé pour modifier les clauses SQL de la requête
function custom_posts_clauses_filter($clauses, $query) {
    global $wpdb;

    // Vérifie si un filtre sur le temps total est défini
    $total_time_filter = $query->get('total_time_filter');

    if (!$total_time_filter) {
        unset($args['total_time_filter']); // Supprime la clé si aucun filtre n'est défini
    } else {
        // Ajoute une jointure pour inclure les champs `prep_time` et `baking_time` dans la requête SQL
        $clauses['join'] .= "
            LEFT JOIN {$wpdb->postmeta} AS prep_time_meta 
                ON ({$wpdb->posts}.ID = prep_time_meta.post_id AND prep_time_meta.meta_key = 'prep_time')
            LEFT JOIN {$wpdb->postmeta} AS baking_time_meta 
                ON ({$wpdb->posts}.ID = baking_time_meta.post_id AND baking_time_meta.meta_key = 'baking_time')
        ";

        // Ajoute une condition pour filtrer les résultats selon le temps total (somme de `prep_time` et `baking_time`)
        $clauses['where'] .= $wpdb->prepare("
            AND (
                (prep_time_meta.meta_value + baking_time_meta.meta_value) <= %d
            )
        ", $total_time_filter);
    }

    return $clauses; // Retourne les clauses modifiées
}

// Fonction pour récupérer les recettes en fonction des paramètres de filtre
function get_recipes($query_params, $paged, $total_time_filter = NULL) {
    $tax_query = [];
    foreach ($query_params as $query_param) {
        // Ajoute chaque filtre de taxonomie à la requête
        $context["terms"][] = new Timber\Term($query_param["slug"], $query_param["taxonomy"]);
        $tax_query[] = [
            "taxonomy" => $query_param["taxonomy"],
            "field" => "slug",
            "terms" => $query_param["slug"],
        ];
    }

    $meta_query = []; // Initialisation des métadonnées

    // Si un filtre sur le temps total est défini, ajoute des conditions correspondantes
    if ($total_time_filter) {
        // Applique le filtre personnalisé pour modifier les clauses SQL
        add_filter('posts_clauses', 'custom_posts_clauses_filter', 10, 2);

        // Ajoute des conditions pour vérifier l'existence des champs `prep_time` et `baking_time`
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
        'post_type'      => 'post', // Type de contenu
        'orderby'        => 'date', // Tri par date
        'posts_per_page' => get_option('posts_per_page'), // Nombre d'articles par page
        'paged'          => $paged, // Page courante
        'tax_query'      => $tax_query, // Filtres de taxonomie
        'meta_query'     => $meta_query, // Filtres de métadonnées
        'total_time_filter' => $total_time_filter, // Filtre personnalisé sur le temps total
    ];

    // Exécution de la requête Timber
    $result_query = new Timber\PostQuery($args);

    // Retire le filtre après la requête pour éviter tout effet de bord
    remove_filter('posts_clauses', 'custom_posts_clauses_filter');

    return $result_query; // Retourne les résultats
}
