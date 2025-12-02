<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Crepo | Connexion</title>
    <!--<link rel="icon" type="image/x-icon" href="images/favicon.png">-->
    <link href="styleLogin.css" rel="stylesheet">
	<link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <main>
        <div class="wrapper">
			<h1>Crepo</h1>
			<form class="choiceButtons" action="" method="post">
				<input class="signinButton" name="inscription" type="submit" value="Créer un compte"/><br>
				<input class="loginButton" name="connexion" type="submit" value="Se connecter"/>
			</form>
			
			<?php
				
				$servername = "localhost";
				$username = "phpclient";
				$password = "php@code/1234";
				$database = "crepobd";
				$connect = mysqli_connect($servername, $username, $password, $database);
				
				if(!$connect){
					die("erreur de connexion a la base de donnée".mysqli_error($connect));
				}
				
				$mysqli = new mysqli($servername, $username, $password, $database);
				
				
				if (isset($_POST['inscription'])) {
					echo '<form action="" method="post">
					Pseudo<br>
					<input name="pseudo" type="text" placeholder="Choisissez un pseudo"/> <br>
					Email<br>
					<input name="email" type="text" placeholder="Choisissez un email"/> <br>
					Password<br> 
					<input name="password" type="password" placeholder="Choisissez un password"/> <br>
					<input name="register" type="submit" value="Inscription"/></form>';
				}
				
				elseif (isset($_POST['connexion'])) {
					echo '<form action="" method="post">
					Pseudo<br>
					<input name="pseudo" type="text" placeholder="Saisissez votre pseudo"/> <br>
					Password<br>
					<input name="password" type="password" placeholder="Saisissez votre password"/><br>
					<input name="login" type="submit" value = "Connexion"/></form>';
				}
				elseif(isset($_POST['register'])){
					if(isset($_POST['user']) and isset($_POST['email']) and isset( $_POST['password'])){
						$requete = "select user, email from user ;";
						$resultat = $mysqli->query($requete);
						$x = 0;
						foreach($resultat as $test){
							if($_POST['email'] == $test['email']){
								$x = 1;
								break;
							}
						}
						if($x == 1){
							echo "information invalide <br>";
							echo '<form action="" method="post">
							Pseudo<br>
							<input name="pseudo" type="text" placeholder="Choisissez un pseudo"/> <br>
							Email<br>
							<input name="email" type="text" placeholder="Choisissez un email"/> <br>
							Password<br> 
							<input name="password" type="password" placeholder="Choisissez un password"/> <br>
							<input name="register" type="submit" value="Inscription"/></form>';
						}
						elseif($_POST['user'] == "" and $_POST['email'] == "" and $_POST['password'] == "")
							$x == 1;
						else{
							$requete = "INSERT INTO `user` (`user`, `password`, `email`) VALUES ('". $_POST['pseudo']."', '". $_POST['password']."', '". $_POST['email']."');";
							$resultat = $mysqli->query($requete);
							echo"inscritpion validée";
						}
					}
					else
						echo "information invalide <br>";
						echo '<form action="" method="post">
							Pseudo<br>
							<input name="pseudo" type="text" placeholder="Choisissez un pseudo"/> <br>
							Email<br>
							<input name="email" type="text" placeholder="Choisissez un email"/> <br>
							Password<br> 
							<input name="password" type="password" placeholder="Choisissez un password"/> <br>
							<input name="register" type="submit" value="Inscription" /></form>'; ;
					
				}
				elseif(isset($_POST['login'])){
					$requete = "select * from user where user = '". $_POST['pseudo']."';";
					$resultat = $mysqli->query($requete);
					foreach($resultat as $test){
						if($_POST['password'] == $test['password'] and $_POST['pseudo'] == $test['user']){
							session_start();
							$_SESSION["connect"] = $test["id_user"] ;
							$url = "projet.php";
							header("Location: $url", true, 302);
							exit();
						}
					}
					echo "information invalide <br>";
					echo '<form action="" method="post">
					Pseudo<br>
					<input name="pseudo" type="text" placeholder="Saisissez votre pseudo"/><br>
					Password<br>
					<input name="password" type="password" placeholder="Saisissez votre password"/><br>
					<input name="login" type="submit" value = "Connexion" /></form>';
					
					
				}
				
			?>
		</div>
    </main>
</body>
</html>

