<?php
$context = Timber::context();

// Charge la page actuelle dans le contexte (nécessaire pour Twig)
$context['recipe'] = new Timber\Post();
$post_id = $context['recipe']->ID;
$context['recipe_tags'] = array_merge(
    get_the_terms($post_id, 'category') ?: [],
    get_the_terms($post_id, 'diet') ?: [],
    get_the_terms($post_id, 'menu_types') ?: []
);

$context['similar_recipes'] = Timber::get_posts([
    'post_type' => 'post',
    'posts_per_page' => 4,
    'post__not_in' => [$post_id],
    'orderby' => 'rand',
]);


// Rendu du template avec le contexte mis à jour
Timber::render('templates/single.twig', $context);

