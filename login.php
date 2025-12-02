<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Crepo | Connexion</title>
    <!--<link rel="icon" type="image/x-icon" href="images/favicon.png">-->
    <link href="styleLogin.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="wrapper">
			<h1>Crepo</h1>
			<hr>
			<div class="infoInput">
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
						<input class="inputBox" name="pseudo" type="text" placeholder="Choisissez un pseudo"/> <br>
						Email<br>
						<input class="inputBox" name="email" type="text" placeholder="Choisissez un email"/> <br>
						Password<br> 
						<input class="inputBox" name="password" type="password" placeholder="Choisissez un password"/> <br>
						<input class="finalButton name="register" type="submit" value="Valider"/></form><br>
						<hr>
						<form class="choiceButtons" action="" method="post">
							<h3>ou</h3><br>
							<input class="loginButton" name="connexion" type="submit" value="Se connecter"/>
						</form>';
					}
					
					elseif (isset($_POST['connexion'])) {
						echo '<form action="" method="post">
						Pseudo<br>
						<input class="inputBox" name="pseudo" type="text" placeholder="Saisissez votre pseudo"/><br>
						Password<br>
						<input class="inputBox" name="password" type="password" placeholder="Saisissez votre password"/><br>
						<input class="finalButton name="login" type="submit" value = "Continuer"/></form><br>
						<hr>
						<form class="choiceButtons" action="" method="post">
							<h3>ou</h3><br>
							<input class="signinButtonBottom" name="inscription" type="submit" value="S\'inscrire"/>
						</form>';
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
								<input class="inputBox" name="pseudo" type="text" placeholder="Choisissez un pseudo"/> <br>
								Email<br>
								<input class="inputBox" name="email" type="text" placeholder="Choisissez un email"/> <br>
								Password<br> 
								<input class="inputBox" name="password" type="password" placeholder="Choisissez un password"/> <br>
								<input class="finalButton name="register" type="submit" value="Valider"/></form><br>
								<hr>
								<form class="choiceButtons" action="" method="post">
									<h3>ou</h3><br>
									<input class="loginButton" name="connexion" type="submit" value="Se connecter"/>
								</form>';
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
								<input class="inputBox" name="pseudo" type="text" placeholder="Choisissez un pseudo"/> <br>
								Email<br>
								<input class="inputBox" name="email" type="text" placeholder="Choisissez un email"/> <br>
								Password<br> 
								<input class="inputBox" name="password" type="password" placeholder="Choisissez un password"/> <br>
								<input class="finalButton name="register" type="submit" value="Valider" /></form><br>
								<hr>
								<form class="choiceButtons" action="" method="post">
									<h3>ou</h3><br>
									<input class="loginButton" name="connexion" type="submit" value="Se connecter"/>
								</form>';
						
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
						<input class="inputBox" name="pseudo" type="text" placeholder="Saisissez votre pseudo"/><br>
						Password<br>
						<input class="inputBox" name="password" type="password" placeholder="Saisissez votre password"/><br>
						<input class="finalButton name="login" type="submit" value = "Continuer" /></form><br>
						<hr>
						<form class="choiceButtons" action="" method="post">
							<h3>ou</h3><br>
							<input class="signinButtonBottom" name="inscription" type="submit" value="S\'inscrire"/>
						</form>';
						
						
					}
					else{
						echo'<form class="choiceButtons" action="" method="post">
								<input class="signinButton" name="inscription" type="submit" value="S\'inscrire"/>
								<h3>ou</h3>
								<input class="loginButton" name="connexion" type="submit" value="Se connecter"/>
							</form>';
					}
					
				?>
			</div>
		</div>
    </main>
</body>
</html>

			<!--<form class="choiceButtons" action="" method="post">
				<input class="signinButton" name="inscription" type="submit" value="S'inscrire"/>
				<h3>ou</h3>
				<input class="loginButton" name="connexion" type="submit" value="Se connecter"/>
			</form>-->