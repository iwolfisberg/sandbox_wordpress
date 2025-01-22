<?php

/** 
 * Enregistre les menus de navigation pour le thème.
 * Cette fonction utilise `register_nav_menus` pour déclarer trois menus : 
 * - Le menu principal (primary)
 * - Le menu secondaire (secondary)
 * - Le menu du pied de page (footer)
 */
add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary' => 'Primary Menu',   // Menu principal, généralement en haut de la page.
        'secondary' => 'Secondary Menu', // Menu secondaire, souvent dans la barre latérale ou en dessous du menu principal.
        'footer' => 'Footer Menu',       // Menu dans le pied de page.
    ]);
});

/**
 * Ajoute les menus au contexte Timber.
 * Cette fonction permet de rendre les menus disponibles dans les fichiers Twig en utilisant le contexte Timber.
 * 
 * Le menu principal est chargé dans le contexte avec la clé 'menu'.
 * Cela permet d’accéder à ce menu dans les templates Twig.
 */
function add_menu_to_context($context) {
    // Charge chaque menu et l'ajoute au contexte Timber sous la clé correspondante.
    $context['primary_menu'] = new \Timber\Menu("primary");
    $current_page = get_permalink(new Timber\Post());
    foreach($context['primary_menu']->items as $item) {
        if ($item->url == $current_page) {
            $item->active = true;
        }
    };
    $context['secondary_menu'] = new \Timber\Menu("secondary");
    $context['footer_menu'] = new \Timber\Menu("footer");

    return $context;
}

// Applique la fonction `add_menu_to_context` au filtre `timber/context` 
// pour que les menus soient accessibles dans les templates Twig.
add_filter('timber/context', 'add_menu_to_context');
