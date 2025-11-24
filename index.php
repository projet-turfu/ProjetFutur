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
        </p>
        
    </main>

</body>

</html>