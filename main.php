<?php

function AfficheTab($tab, $m, $n, $nmJoueur)
{
    echo("         Joueur " . $nmJoueur . "\n");
    echo("------------------------"  . "\n");
    echo("    A B C D E F G H I J" . "\n");
    echo("    | | | | | | | | | |" . "\n");
    for ($i = 0; $i < $m; $i++) {
        echo $i . " - ";
        for ($j = 0; $j < $n; $j++) {
            echo $tab[$i][$j] . " ";
        }
        echo "\n";
    }
    echo "------------------------\n";
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
            $codeBateau = 22;
            break;
        case "sous-marin":
            $codeBateau = 33;
            break;
        case "croiseur":
            $codeBateau = 44;
            break;
        case "porte-avion":
            $codeBateau = 55;
            break;
        case "sous-marin2":
            $codeBateau = 63;
            break;
    }
    return $codeBateau;
}

function NombreBateau($grille, $nomBateau)
{
    $compteurBateau = 0;
    if ($nomBateau == "sous-marin")
{
    $codeBateau = 6;
    for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < 10; $j++) {
            if ($grille[$i][$j] == $codeBateau) {
                $compteurBateau += 1;
            }
        }

    }
}

    $codeBateau = intdiv(CodeBateau($nomBateau),10) % 10 ;
    for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < 10; $j++) {
            if ($grille[$i][$j] == $codeBateau) {
                $compteurBateau += 1;
            }
        }

    }
    return floor($compteurBateau / $codeBateau);
}

function PoseBateau(&$grille)
{
    $compteurBateau = 0;
    while ($compteurBateau < 5) {


        $incorrect = true;
        while ($incorrect) {
            echo("Disposition actuelle \n");
            AfficheTab($grille, 10, 10, 1);
            echo 'il vous reste '. (5 - $compteurBateau). " bateau a poser \n" ;
            $nomBateau = readline("Quel Bateau souhaitez vous poser ? ");
            if ($nomBateau == "sous-marin") {
                if (NombreBateau($grille, $nomBateau) == 0) {
                    $incorrect = false;
                    $compteurBateau++;

                } else if (NombreBateau($grille, $nomBateau) == 1) {
                    $nomBateau = "sous-marin2";
                    $incorrect = false;
                    $compteurBateau++;

                } else {
                    echo("Il y a déjà deux sous marins, il ne peut y en avoir que deux \n");
                }
            } else if ($nomBateau == "torpilleur" or $nomBateau == "croiseur" or $nomBateau == "porte-avion") {
                if (NombreBateau($grille, $nomBateau) < 1) {
                    $incorrect = false;
                    $compteurBateau++;
                } else {
                    echo("Il y a déjà un bateau comme ça, il ne peut y avoir qu'une seule fois ce type de bateau \n");
                }
            } else {
                echo "nom de bateau incorrect \n";
            }
        }
        PositionneAnyBateau($grille, $nomBateau);
    }
}

function PositionneAnyBateau(&$grille, $nomBateau)
{
    $posCorrect = false;
    while ($posCorrect == false)
    {
        $l = readline("Sur quelle ligne voulez vous positionner le $nomBateau ? ");
        while (!(ctype_digit((string)$l)) or $l < 0 or $l > 9) {
            $l = readline("Ce n'est pas une position valide, \nSur quelle ligne voulez vous repositionner le $nomBateau ? ");
        }
        $c = 10;
        $erreur = false;
        while ($c < 0 or $c > 9) {
            if (!$erreur)
                $c = readline("Sur quelle colonne voulez vous positionner le $nomBateau ? ");
            if($erreur)
                $c = readline("Ce n'est pas une position valide, \nSur quelle colonne voulez vous repositionner le $nomBateau ? ");

            $c = NumColone($c);
            if ($c == 10)
                $erreur = true;
        }

        $vertical = readline("Voulez-vous postionner le $nomBateau en vertical ? (oui/non) ");
        while ($vertical != 'oui' and $vertical != 'non')
        {
            $vertical = readline("Ce n'est pas une réponse valide, \nVoulez-vous postionner le $nomBateau en horizontal ? (oui/non UNIQUEMENT) ");
        }

        if ($vertical == 'oui')
        {
            $direction = $l;
        } else {
            $direction = $c;
        }
        if ($direction > 10 - (CodeBateau($nomBateau ) % 10))
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
            for ($i = $direction; $i != $direction + (CodeBateau($nomBateau)%10); $i += 1) {
                if ($vertical == 'oui') {
                    $l = $i;
                } else {
                    $c = $i;
                }

                if ($grille[$l][$c] != 0) {
                    echo("le $nomBateau chevauche au moins un autre bateau, veuillez recommencer \n");
                    $posCorrect = false;
                    break;
                }

            }
        }
    }
    for ($i = $direction; $i != $direction + (CodeBateau($nomBateau)%10); $i += 1) {
        if ($vertical == 'oui') {
            $l = $i;
        }
        else
        {
            $c = $i;
        }
       $grille[$l][$c] = (intdiv(CodeBateau($nomBateau),10)%10);

    }
}

function NumColone($numColone)
{
    switch ($numColone) {
        case "A":
            $numColone = 0;
            break;
        case "B":
            $numColone = 1;
            break;
        case "C":
            $numColone = 2;
            break;
        case "D":
            $numColone = 3;
            break;
        case "E":
            $numColone = 4;
            break;
        case "F":
            $numColone = 5;
            break;
        case "G":
            $numColone = 6;
            break;
        case "H":
            $numColone = 7;
            break;
        case "I":
            $numColone = 8;
            break;
        case "J":
            $numColone = 9;
            break;
        default:
            $numColone = 10;
            break;

    }
    return $numColone;
}

function Tire(&$grille, &$grilleATK)
{
    $TireCorrect = false;
    while ($TireCorrect == false) {
        $toucher = true;
        while ($toucher) {
            AfficheTab($grilleATK,10,10,1);
            $l_tire = readline('Sur quelle ligne souhaitez vous tirer ?');
            while (!(ctype_digit((string)$l_tire)) or $l_tire < 0 or $l_tire > 9) {
                $l_tire = readline("Ce n'est pas une ligne valide. \nSur quelle ligne souhaitez vous tirer ?");
            }


            $c_tire = 10;
            $erreur = false;
            while ($c_tire < 0 or $c_tire > 9) {
                if (!$erreur)
                    $c_tire = readline('Sur quelle colonne souhaitez vous tirer ?');
                if($erreur)
                    $c_tire = readline("Ce n'est pas une colone valide. \nSur quelle colonne souhaitez vous tirer ?");

                $c_tire = NumColone($c_tire);
                if ($c_tire == 10)
                    $erreur = true;
            }


                if ($grille[$l_tire][$c_tire] == 'X' or $grille[$l_tire][$c_tire] == 'V') {
                echo('Vous avez déjà tiré ici'. "\n");
                $TireCorrect = false;
            } else if ($grille[$l_tire][$c_tire] == 0) {
                $grille[$l_tire][$c_tire] = 'X';
                $grilleATK[$l_tire][$c_tire] = 'X';
                echo("Loupé, c'est au tour de l'adversaire \n");
                $TireCorrect = true;
                $toucher = false;
            } else {
                $grille[$l_tire][$c_tire] = 'V';
                $grilleATK[$l_tire][$c_tire] = 'V';
                echo('Touché, vous pouvez re-tirer'. "\n");
                $TireCorrect = true;

                Couler($grille,"torpilleur");
                Couler($grille,"sous-marin");
                Couler($grille,"sous-marin2");
                Couler($grille,"croiseur");
                Couler($grille,"porte-avion");

            }
        }
    }
}

function Couler($grille, $nomBateau)
{
    $compteurBateau = 0;
    $codeBateau = intdiv(CodeBateau($nomBateau),10) % 10 ;
    for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < 10; $j++) {
            if ($grille[$i][$j] == $codeBateau) {
                $compteurBateau += 1;
            }
        }

    }
    if ($compteurBateau == 0)
    {
        echo("Vous avez couler le $nomBateau \n");
        FinDeJeu($grille);
    }
}

function FinDeJeu($grille)
{
    for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < 10; $j++) {
            if ($grille[$i][$j] == 2 or $grille[$i][$j] == 3 or $grille[$i][$j] == 4 or $grille[$i][$j] == 5 or $grille[$i][$j] == 6)
            {
                $compteurBateau += 1;
            }
        }

    }
    if ($compteurBateau == 0)
    {
        echo("Bien jouer vous avez gagner \n");
    }
}

function Jeu(){
    $grilleJ1=initialisegrille();
    $grilleJ1ATK=initialisegrille();
    $grilleJ2=initialisegrille();
    $grillleJ2ATK=initialisegrille();


    PoseBateau($grilleJ1);
    PoseBateau($grilleJ2);

    $fin = false;
    $joueur = 1;
    $echange = 2;
    while (!$fin)
    {
        if ($joueur == 1)
        {
            Tire($grilleJ2, $grilleJ2ATK);
        }
        else
        {
            Tire($grilleJ1, $grilleJ1ATK);
        }

        $temp = $joueur;
        $joueur = $echange;
        $echange = $temp;
    }
}




$grilleJ1 = InitialiseGrille();
$grilleJ1ATK = InitialiseGrille();

PoseBateau($grilleJ1);

Tire($grilleJ1, $grilleJ1ATK);