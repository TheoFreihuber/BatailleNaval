<?php

function AfficheTab($tab, $m, $n, $nmJoueur)
{
    echo("     Joueur " . $nmJoueur . "\n");
    for ($i = 0; $i < $m; $i++) {
        for ($j = 0; $j < $n; $j++) {
            echo $tab[$i][$j] . " ";
        }
        echo "\n";
    }
    echo "-------------------\n";
}

function InitialiseGrille()
{
    for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < 10; $j++) {
            $grille[$i][$j] = 0;
        }
    }
    return $grille;
}

function CodeBateau($nomBateau)
{
    switch ($nomBateau) {
        case "torpilleur":
            $codeBateau = 2;
            break;
        case "sous-marin":
            $codeBateau = 3;
            break;
        case "croiseur":
            $codeBateau = 4;
            break;
        case "porte-avion":
            $codeBateau = 5;
            break;
    }
    return $codeBateau;
}

function NombreBateau($grille, $nomBateau)
{
    $compteurBateau = 0;

    $codeBateau = CodeBateau($nomBateau);

    for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < 10; $j++) {
            if ($grille[$i][$j] == $codeBateau) {
                $compteurBateau += 1;
            }
        }

    }
    $compteurBateau = $compteurBateau / $codeBateau;
    return $compteurBateau;
}

function PoseBateau(&$grille)
{
    $incorrect = true;
    while ($incorrect)
    {
        echo("Disposition actuelle \n");
        AfficheTab($grille, 10, 10, 1);
        $nomBateau = readline("Quel Bateau souhaitez vous poser ? ");
        if ($nomBateau == "sous-marin") {
            if (NombreBateau($grille, $nomBateau) < 2) {
                $incorrect = false;

            } else {
                echo("Il y a déjà deux sous marin, il ne peut y en avoir que deux \n");
            }
        } else if ($nomBateau == "torpilleur" or $nomBateau == "croiseur" or $nomBateau == "porte-avion") {
            if (NombreBateau($grille, $nomBateau) < 1) {
                $incorrect = false;
            } else {
                echo("Il y a déjà un bateau comme ça, il ne peut y avoir qu'une seule fois ce type de bateau \n");
            }
        }
        else
        {
            echo "nom de bateau incorrect \n";
        }
    }
    PositionneAnyBateau($grille, $nomBateau);
}

function PositionneAnyBateau(&$grille, $nomBateau)
{
    $posCorrect = false;
    while ($posCorrect == false)
    {
        $l = readline("Sur quelle ligne voulez vous positionner le bateau ? ");
        while ($l < 0 or $l > 10) {
            $l = readline("Ce n'est pas une position valide, \n Sur quelle ligne voulez vous repositionner le bateau ? ");
        }
        $c = readline("Sur quelle colonne voulez vous positionner le bateau ? ");
        while ($c < 0 or $c > 10) {
            $c = readline("Ce n'est pas une position valide, \n Sur quelle colonne voulez vous repositionner le bateau ? ");
        }

        $position = readline("Voulez-vous postionner le bateau en vertical ? (oui/non) ");
        while ($position != 'oui' and $position != 'non')
        {
            $position = readline("Ce n'est pas une réponse valide, \n Voulez-vous postionner le bateau en horizontal ? (oui/non UNIQUEMENT) ");
        }

        if ($position == 'oui')
        {
            $direction = $l;
        } else {
            $direction = $c;
        }
        if ($direction > 10 - CodeBateau($nomBateau))
        {
            echo("la position sort du plateau, veuillez recommencer \n");
            $sortPlateau = true;
        }
        else
        {
            $sortPlateau = false;
        }
        if ($sortPlateau == false) {
            $posCorrect = true;
            for ($i = $direction; $i != $direction + CodeBateau($nomBateau); $i += 1) {
                if ($position == 'oui') {
                    $l = $i;
                } else {
                    $c = $i;
                }

                if ($grille[$l][$c] != 0) {
                    echo("Le bateau chevauche au moins un autre bateau, veuillez recommencer \n");
                    $posCorrect = false;
                    break;
                }

            }
        }
    }
    for ($i = $direction; $i != $direction + CodeBateau($nomBateau); $i += 1) {
        if ($position == 'oui') {
            $l = $i;
        }
        else
        {
            $c = $i;
        }
        $grille[$l][$c] = CodeBateau($nomBateau);
    }
}

function Tire(&$grille)
{
    $TireCorrect = false;
    while ($TireCorrect == false){
        $l_tire = readline('Sur quelle ligne souhaitez vous tirer ?');
        $c_tire = readline('Sur quelle colonne souhaitez vous tirer ?');

        if($grille[$l_tire][$c_tire] == 'X' or $grille[$l_tire][$c_tire] == 'V' ){
            echo('Vous avez déjà tiré ici');
            $TireCorrect = false;
        }

        if($grille[$l_tire][$c_tire] == 0){
            $grille[$l_tire][$c_tire] = 'X';
            echo('Loupé');
            $TireCorrect = true;
        }

        if($grille[$l_tire][$c_tire] != 0 and $grille[$l_tire][$c_tire] != 'X' and $grille[$l_tire][$c_tire] != 'V' ){
            $grille[$l_tire][$c_tire] = 'V';
            echo('Touché');
            $TireCorrect = true;
        }

    }
}

function Jeu($joueur1,$joueur2){
    $grilleJ1=initialisegrille();
    $grilleJ2=initialisegrille();


    //PositionneAnyBateau(&$grilleJ1, $nomBateau)
    //PositionneAnyBateau(&$grilleJ2, $nomBateau)

    $fin = false;
    $joueur = 1;
    $echange = 2;
    while ($fin = false){
        if ($joueur = 1){
            echo 'Joueur 1 à vous de tirez.';
            Tire($grilleJ2);
        }
        elseif ($joueur = 2){
            echo 'Joueur 2 à vous de tirez.';
            Tire($grilleJ1);
        }

        $temp = $joueur;
        $joueur = $echange;
        $echange = $temp;
    }
}



$grilleJ1 = InitialiseGrille();
while(true)
    PoseBateau($grilleJ1);

