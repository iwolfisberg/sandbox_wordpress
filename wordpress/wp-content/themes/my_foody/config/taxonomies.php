<?php
/** Configuration relative aux taxonomies personnalisées */

class Taxonomy extends StarterSite
{
  function __construct()
  {
    parent::__construct();

  }

  public function register_taxonomies()
  {
    $this->register_diet_taxonomy();
    $this->register_menu_types_taxonomy();
  }

  /**
   * Enregistre une taxonomie personnalisée "Types de menu" pour les articles.
   * Cette fonction crée une taxonomie "menu_types" associée aux publications (post).
   * Elle permet d’ajouter un système de catégorisation personnalisé pour les types de menus dans l'éditeur de contenu.
   */
  private function register_menu_types_taxonomy()
  {
    register_taxonomy(
      'menu_types',  // Nom de la taxonomie
      'post',        // Type de contenu auquel la taxonomie est associée
      [
        'label' => __('Types de menu'), // Libellé de la taxonomie
        'sort' => true, // Permet de trier les termes de cette taxonomie
        'hierarchical' => true, // Permet d'organiser les termes en hiérarchie (comme les catégories)
        'args' => ['orderby' => 'term_order'], // Trie les termes par ordre défini dans l'interface d'administration
        'rewrite' => ['slug' => 'type-menu'], // Définit le slug pour l'URL de cette taxonomie
        // Permet d'afficher la boîte de la taxonomie dans l'éditeur de publications (articles)
        'show_in_rest' => true // Nécessaire pour que la taxonomie soit disponible dans l'éditeur de blocs (Gutenberg)
      ],
    );
  }

  private /**
    * Enregistre une taxonomie personnalisée "Mode d'alimentation" pour les articles.
    * Cette fonction crée une taxonomie "diet" associée aux publications (post).
    * Elle permet d’ajouter un système de catégorisation pour les régimes alimentaires dans l'éditeur de contenu.
    */
    function register_diet_taxonomy(
  ) {
    register_taxonomy(
      'diet',  // Nom de la taxonomie
      'post',  // Type de contenu auquel la taxonomie est associée
      [
        'label' => __("Mode d'alimentation"), // Libellé de la taxonomie
        'sort' => true, // Permet de trier les termes de cette taxonomie
        'hierarchical' => true, // Permet d'organiser les termes en hiérarchie (comme les catégories)
        'args' => ['orderby' => 'term_order'], // Trie les termes par ordre défini dans l'interface d'administration
        'rewrite' => ['slug' => 'mode-alimentation'], // Définit le slug pour l'URL de cette taxonomie
        // Permet d'afficher la boîte de la taxonomie dans l'éditeur de publications (articles)
        'show_in_rest' => true, // Nécessaire pour que la taxonomie soit disponible dans l'éditeur de blocs (Gutenberg)
      ],
    );
  }
}
