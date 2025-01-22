<?php

/**
 *  Configuration du thème.
 */
class Setting extends StarterSite
{
    function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('init', [$this, 'add_custom_query_var']);
        parent::__construct();

    }

    public function enqueue_assets()
    {
        // Chemin absolu vers le dossier dist
        $dist_dir = get_template_directory() . '/dist';
        $dist_uri = get_template_directory_uri() . '/dist';

        // Initialiser les chemins des fichiers CSS et JS
        $css_file = '';
        $js_file = '';

        // Lire les fichiers du dossier dist/css
        if (is_dir($dist_dir . '/css')) {
            $css_files = glob($dist_dir . '/css/index.*.css');
            if (!empty($css_files)) {
                // Prend le premier fichier trouvé
                $css_file = basename($css_files[0]);
            }
        }

        // Lire les fichiers du dossier dist/js
        if (is_dir($dist_dir . '/js')) {
            $js_files = glob($dist_dir . '/js/index.*.js');
            if (!empty($js_files)) {
                // Prend le premier fichier trouvé
                $js_file = basename($js_files[0]);
            }
        }

        // Enfile les fichiers si trouvés
        if ($css_file) {
            wp_enqueue_style('foody-style', $dist_uri . '/css/' . $css_file, [], null);
        }

        if ($js_file) {
            wp_enqueue_script('foody-js', $dist_uri . '/js/' . $js_file, [], null, true);
        }
    }

    /**
     * Ajoute des informations supplémentaires au contexte Timber.
     * 
     * Le contexte est une collection de variables disponibles dans les fichiers Twig.
     * @param string $context context['this'] Being the Twig's {{ this }}.
     */
    public function add_to_context($context)
    {
        $context['site'] = $this;
        // Ajoute l'URL de la page d'accueil au contexte.
        $context['home_url'] = home_url();
        $context['search_page_url'] = $context['home_url'] . '/?s=';

        // Récupère l'ID de la page définie comme "Page des articles" dans les réglages WordPress.
        $front_page_id = get_option('page_for_posts');

        // Ajoute l'URL de cette page au contexte.
        if ($front_page_id) {
            $context['front_page'] = get_permalink($front_page_id);
        } else {
            // Gère le cas où aucune page "Page des articles" n'est définie.
            $context['front_page'] = '#';
        }

        return $context;
    }

    /**
     * Ajoute des variables de requête personnalisées pour WordPress.
     * 
     * Ces variables sont utilisées dans les URL pour filtrer les requêtes ou transmettre des paramètres spécifiques.
     */
    public function add_custom_query_var()
    {
        global $wp;

        // Ajout d'une variable pour filtrer par "temps total" (champ ACF personnalisé).
        $wp->add_query_var('total_time');

        // Ajout d'une variable pour la recherche globale par mot-clé.
        $wp->add_query_var('query');

        // Ajout de variables pour filtrer les résultats par taxonomies spécifiques.
        $wp->add_query_var('category');   // Taxonomie "catégorie".
        $wp->add_query_var('diet');      // Taxonomie "régime alimentaire".
        $wp->add_query_var('menu_types'); // Taxonomie "types de menu".
    }

}