

<!doctype html>
<html lang="en">
<body>
    <main>
        
        <form action="" method="post">
			<input name="inscription" type="submit" value="inscription"/>
			<input name="connexion" type="submit" value="connexion"/>
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
				pseudo:
				<input name="pseudo" type="text" /> <br>
				email:
				<input name="email" type="text" /> <br>
				password: 
				<input name="password" type="text" /> <br>
				<input name="register" type="submit" />';
			}
			
			elseif (isset($_POST['connexion'])) {
				echo '<form action="" method="post">
				pseudo:
				<input name="pseudo" type="text" /> <br>
				password: 
				<input name="password" type="text" /> <br>
				<input name="login" type="submit" />';
			}
			elseif(isset($_POST['register'])){
				$requete = "select user, email from user ;";
				$resultat = $mysqli->query($requete);
				$x = 0;
				foreach($resultat as $test){
					if($_POST['email'] == $test['email'] and $_POST['user'] == $test['user']){
						$x = 1;
						break;
					}
				}
				if($x == 1){
					echo "information invalide <br>";
					echo '<form action="" method="post">
					pseudo:
					<input name="pseudo" type="text" /> <br>
					email:
					<input name="email" type="text" /> <br>
					password: 
					<input name="password" type="text" /> <br>
					<input name="register" type="submit" />';
				}
				else{
					$requete = "INSERT INTO `user` (`user`, `password`, `email`) VALUES ('". $_POST['pseudo']."', '". $_POST['password']."', '". $_POST['email']."');";
					$resultat = $mysqli->query($requete);
					echo"inscritpion validée";
				}
				
			}
			elseif(isset($_POST['login'])){
				$requete = "select * from user where user = '". $_POST['pseudo']."';";
				$resultat = $mysqli->query($requete);
				foreach($resultat as $test){
					if($_POST['password'] == $test['password'] and $_POST['pseudo'] == $test['user']){
						echo "connexion valide";
						$url = "projet.php";
						header("Location: $url", true, 302);
						exit();
					}
				}
				echo "information invalide <br>";
				echo '<form action="" method="post">
				pseudo:
				<input name="pseudo" type="text" /> <br>
				password: 
				<input name="password" type="text" /> <br>
				<input name="login" type="submit" />';
				
				
			}
        ?>
    </main>
</body>
</html>