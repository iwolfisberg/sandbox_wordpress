<?php

/** 
 * Enregistre les menus de navigation pour le thème.
 * Cette class utilise `register_nav_menus` pour déclarer trois menus : 
 * - Le menu principal (primary)
 * - Le menu secondaire (secondary)
 * - Le menu du pied de page (footer)
 */
class Menu extends StarterSite
{
    function __construct()
    {
        add_action('after_setup_theme', [$this, 'register_menus']);
        add_action('init', [$this, 'add_custom_query_var']);
        parent::__construct();

    }

    public function register_menus()
    {
        register_nav_menus([
            'primary' => 'Primary Menu',   // Menu principal, généralement en haut de la page.
            'secondary' => 'Secondary Menu', // Menu secondaire, souvent dans la barre latérale ou en dessous du menu principal.
            'footer' => 'Footer Menu',       // Menu dans le pied de page.
        ]);
    }

    public function add_to_context($context)
    {
        // Charge chaque menu et l'ajoute au contexte Timber sous la clé correspondante.
        $context['primary_menu'] = new \Timber\Menu("primary");
        $current_page = get_permalink(new Timber\Post());
        foreach ($context['primary_menu']->items as $item) {
            if ($item->url == $current_page) {
                $item->active = true;
            }
        }
        ;
        $context['secondary_menu'] = new \Timber\Menu("secondary");
        $context['footer_menu'] = new \Timber\Menu("footer");

        return $context;
    }
}





