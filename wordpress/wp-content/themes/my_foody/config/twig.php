<?php
/** Ajouter des fonctions personnalisées à Twig pour le thème */

class TwigFunction extends StarterSite
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Fonction pour convertir les minutes en format heures et minutes avec validation de l'entrée.
     * 
     * Cette fonction prend un nombre de minutes et le convertit en un format lisible sous forme d'heures et minutes.
     * Par exemple, 125 minutes devient "2h05".
     *
     * @param int $minutes Nombre de minutes à convertir.
     * @return string|null Retourne la chaîne formatée "xh yy" (par exemple "2h05") ou "xx min." si inférieur à 60 minutes.
     */
    public function minutes_to_hours(
        $minutes
    ) {
        // Vérifie si l'entrée est un nombre entier valide et positif
        if (!is_numeric($minutes) || $minutes < 0) {
            return null; // Retourne null si l'entrée est invalide
        }

        // Si le nombre de minutes est inférieur à 60, on le retourne avec "min."
        if ($minutes < 60) {
            return $minutes . ' min.';
        }

        // Calcul des heures et des minutes restantes
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;

        // Format des minutes avec deux chiffres (par exemple 5 devient 05)
        $formatted_minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        // Retourne le format "xhyy" (par exemple "2h05" pour 125 minutes)
        return $hours . 'h' . $formatted_minutes;
    }

    public function add_to_twig($twig)
    {
        parent::add_to_twig($twig);

        // Ajout de la fonction personnalisée "minutes_to_hours" dans Twig
        $twig->addFunction(new Twig\TwigFunction('minutes_to_hours', [$this, 'minutes_to_hours']));
        // ajoute la fonction native d'ACF get_field à l'environnement Twig
        $twig->addFunction(new Twig\TwigFunction('get_field', [$this, 'get_field']));
        // Retourne l'environnement Twig modifié
        return $twig;
    }
}

