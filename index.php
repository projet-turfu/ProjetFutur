<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Gestion de projets</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <header>
        
    </header>

    <main>
        <h2>Page de test</h2>
        <p>
            Cette page contient <strong>uniquement</strong> du code HTML.<br/>


            Voici quelques petits tests :


        </p>

        <ul>
            <li style="color: blue;">Texte en bleu</li>
            <li style="color: red;">Texte en rouge</li>
            <li style="color: green;">Texte en vert</li>
        </ul>

         <h2>Affichage de texte avec PHP</h2>
        
        <p>
            Cette ligne a été écrite entièrement en HTML.<br />
            <?php echo("Celle-ci a été écrite entièrement en PHP."); ?>
            Aujourd'hui nous sommes le <?php echo date('d/m/Y h:i:s'); // sert à afficher date et heure ?>. 
            <?php $fullname = "Mathieu Nebra"; echo "Bonjour {$fullname} et bienvenue sur le site !"; ?>
            <br>
            <?php echo 'Bonjour ' . $fullname . ' !'; ?>
        </p>
        <p>
            <?php
                //$number = 2 + 4;
                //$number = 5 - 1;
                //$number = 3 * 5;
                //$number = 10 / 2;
                //$number = 3 * 5 + 1;
                //$number = (1 + 2) * 2;
                $number = 10;
                $result = ($number + 5) * $number;
                echo $result;
            ?>
        </p>
        <p>
            <?php
                $isEnabled = false;

                if ($isEnabled === true) {
                    echo "Vous êtes autorisé(e) à accéder au site";
                }
                else {
                    echo "Accès refusé";
                }
            ?>
            <br>
            <?php
                $isAllowedToEnter = "Non";

                
                if ($isAllowedToEnter === "Oui") {
                    echo "YEP";
                } 
                elseif ($isAllowedToEnter === "Non") {
                    echo "NOPE";
                } 
                else {
                    echo "TRY AGAIN";
                }
            ?>
            <br>
            <?php
                $isAllowedToEnter = true;

                if ($isAllowedToEnter) {
                    echo "Bienvenue";
                }
                else {
                    echo "Denied";
                }
            ?>
            <br>
            <?php
                $isEnabled = true;
                $isOwner = true;

                if ($isEnabled && $isOwner) {
                    echo "Oui";
                } else {
                    echo "Non";
                }
            ?>
            <br>
            <?php
                $isEnabled = true;
                $isOwner = true;
                $isAdmin = false;

                if (($isEnabled && $isOwner) || $isAdmin) {
                    echo "YEP";
                } else {
                    echo "NOPE";
                }
            ?>
            <br>
            <?php $chickenRecipesEnabled = false; ?>

            <?php if ($chickenRecipesEnabled): ?>

            <h1>Chicken recipe</h1>

            <?php elseif (! $chickenRecipesEnabled): ?>

            <h1>look at all these recipes</h1>

            <?php endif; ?>
            <br>
            <?php
                $grade = 0;

                switch ($grade) { 
                    case 0:
                        echo "boo";
                    break;
                    
                    case 5:
                        echo "yikes";
                    break;
                    
                    case 10: 
                        echo "average";
                    break;
                    
                    case 20:
                        echo "yippee";
                    break;
                    
                    default:
                        echo "huh";
                }
            ?>
        </p>
        <p>
            <?php
                $user1 = ['Quentin', 'email', 'mdp', 28];

                echo " ton prénom {$user1[0]} "; 
                echo "ton email {$user1[1]} "; 
                echo "ton âge {$user1[3]} "; 
            ?>
            <br>
            <?php
                $mickael = ['Mickaël', 'mickael@exemple.com', 'S3cr3t', 34];
                $mathieu = ['Mathieu', 'mathieu@exemple.com', 'devine', 33];
                $laurene = ['Laurène', 'laurene@exemple.com', 'P4ssw0rD', 28];

                $users = [$mickael, $mathieu, $laurene];

                echo $users[1][1];
            ?>
        </p>
        <p>
            <?php
                //$isValid = true;

                //while ($isValid) {
                    //echo "valide";
                //}
            ?>
        </p>
        
    </main>

</body>

</html>