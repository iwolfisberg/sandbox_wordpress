<?php
/**
 * Class de fonctions utilitaires pour le thème.
 */

class Helpers
{
    function __construct()
    {
    }

    /**
     * Récupère un nombre donné de termes aléatoires à partir d'un tableau.
     *
     * @param array $terms Tableau des termes.
     * @param int   $number Nombre de termes à retourner.
     * @return array Tableau contenant $number termes aléatoires.
     */
    public static function get_X_random_terms($terms, $number)
    {
        shuffle($terms); // Mélange les termes pour les randomiser
        return array_slice($terms, 0, $number); // Retourne les $number premiers termes
    }
}


