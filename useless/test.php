<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Test</title>
</head>

<body>
    <main>
        
        <form action="" method="post">
            yo: <input name="variable" type="text" />
        <input name="submit" type="submit" />
</form>
<?php
            if (isset($_POST['submit'])) {
                $variable = $_POST['variable'];
                echo $variable . " ";
            }
        ?>
    </main>
</body>
</html>