<?php

	session_start();
	
	if(isset($_POST["deco"]) ){
		unset($_SESSION["connect"]);
		$url = "login.php";
		header("Location: $url", true, 302);
		exit();
	}
	
	elseif(isset($_SESSION["connect"])){
		
		
		$servername = "localhost";
		$username = "phpclient";
		$password = "php@code/1234";
		$database = "crepobd";
		$connect = mysqli_connect($servername, $username, $password, $database);
		$mysqli = new mysqli($servername, $username, $password, $database);
		
		$requete = "select nom from project ;";
		$resultat = $mysqli->query($requete);
		
		
		if(isset($_SESSION["crea"]) )
			$_SESSION["crea"] = 1;
		else
			$_SESSION["crea"] = 2;
		
		$x = 0;
		
		
		
		
		if((isset($_POST["projet"]) or isset($_SESSION["projet"]) or $_SESSION["crea"] == 1) and True != isset($_POST["retourtask"])){
			unset($_SESSION["crea"]);
			if(isset($_POST["projet"])){
				foreach($resultat as $test){
					if($_POST["projet"]==$test['nom']){
						$x = 1;
						$p = 1;
					}
				}
			}
			
			elseif(isset($_SESSION["projet"])){
				foreach($resultat as $test){
					if($_SESSION["projet"]==$test['nom']){
						$x = 2;
						$p = 2;
					}
				}
			}
			
			
			if($x == 0 )
				exit;
			else{
				if($p == 1)
					$nomp = $_POST["projet"];
				else
					$nomp = $_SESSION["projet"];
				
				$stmt = $mysqli->prepare("select nom, contenu, priority from task where id_project=(select id_project from project where nom = ? )order by priority DESC;");
				$stmt->bind_param("s", $nomp);
				$stmt->execute();
				$resultat = $stmt->get_result();
				
				foreach($resultat as $res){
					echo "Nom de la tâche: ".$res["nom"]."<br>";
					if ($res["priority"] >= 11)
						echo "Priorité: Extrême<br>";

					elseif ($res["priority"] >= 9)
						echo "Priorité: Très Haute<br>";

					elseif ($res["priority"] >= 7)
						echo "Priorité: Haute<br>";

					elseif ($res["priority"] >= 5)
						echo "Priorité: Moyenne<br>";

					elseif ($res["priority"] >= 3)
						echo "Priorité: Basse<br>";

					elseif ($res["priority"] >= 1)
						echo "Priorité: Très Basse<br>";
					echo "Description: ".$res["contenu"]."<br>";
					echo "-------------------------------------------------------------------------------------------------- <br>";
					
				}
				
				
				
				echo '<form action="" method="post">
				Nom:
				<input name="nom" type="text" /> <br>
				Contenu: 
				<input name="contenu" type="text" /> <br>
				<label for="prio-select">Priotité:</label>

				<select name="prio" id="pet-select">
				  <option value="">--Please choose an option--</option>
				  <option value="11">Extrème</option>
				  <option value="9">Très Haute</option>
				  <option value="7">Haute</option>
				  <option value="5">Moyenne</option>
				  <option value="3">Basse</option>
				  <option value="1">Très Basse</option>
				</select><br>
				date de début de tâche:
				<input name="start" type="date" /> <br>
				date de fin de tâche:
				<input name="end" type="date" /> <br>
				<input name="task" type="submit" value = task />
				</form>';
				echo  '<form action="" method="post">
				<input name="retourtask" type="submit" value = retour />
				</form>';
				
				$stmt = $mysqli->prepare("select id_project from project where nom = ? ;");
				$stmt->bind_param("s", $nomp);
				$stmt->execute();
				$res_rec = $stmt->get_result();

				foreach($res_rec as $res){
					$id = $res["id_project"];
					$status = 0;
					
					if(isset($_POST["projet"]))
						$_SESSION["projet"] = $_POST["projet"];
					
					if(isset($_POST["prio"]) and isset($_POST["contenu"]) and isset($_POST["nom"]) and isset($_POST["start"])and isset($_POST["end"])){
						
						$contenuf = $_POST["contenu"];
						$nomf = $_POST["nom"];
						$priof = $_POST["prio"];
						$start = $_POST["start"];
						$end = $_POST["end"];
						
						if($contenuf != NULL and $start != NULL and $end != NULL and $priof != NULL and $nomf != NULL){
							
						
							$stmt = $mysqli->prepare("INSERT INTO `task` (`id_project`, `nom`, `contenu`, `status`, `priority`, `date_start`, `date_end`) VALUES (?, ?, ?, ?, ?,?, ?);");
							$stmt->bind_param("issiiss", $id, $nomf, $contenuf, $status, $priof, $start, $end);
							$stmt->execute();
							
							$url = "projet.php";
							header("Location: $url", true, 302);
							exit();
							
							
						}
						
						
					}
				}
				
			}
			
		}
		
		
		else {
			
			unset($_SESSION["crea"]);
			
			$requete = "select nom, contenu from project ;";
			$resu = $mysqli->query($requete);
			
			foreach($resu as $res){
				echo"<p>";
				echo'<form action="" method="post">
				<input name = "projet" type="submit" value="'.$res["nom"].'" /><br>
				'.$res["contenu"].'</form><br></p>';
			}
			
			if(isset($_POST["projet"])){
				$_SESSION["crea"] = 1;
				$url = "projet.php";
				header("Location: $url", true, 302);
			}
			
			if(isset($_POST['retourtask'])){
				unset($_POST['retourtask']);
				unset($_SESSION["projet"]);
			}
			
			if(isset($_POST["crea"]) and $_POST["crea"] == "create"){
				$stmt = $mysqli->prepare("select nom from project ;");
				$stmt->execute();
				$res_rec = $stmt->get_result();
				
				$contenuc = $_POST["contenucrea"];
				$nomc = $_POST["nomcrea"];
				$x = 0;
				
				foreach ($res_rec as $res) {
					$status = 0;
					
					if($nomc == $res["nom"]){
						echo "information invalide";
						$x = 1;
					}
				}
				
				
				if($x==0 and isset($_POST["nomcrea"]) and isset($_POST["contenucrea"]) and $_POST["nomcrea"] != NULL and $_POST["contenucrea"] != NULL){
					
					$stmt = $mysqli->prepare("INSERT INTO `project` (`nom`, `contenu`) VALUES (?, ?);");
					$stmt->bind_param("ss", $_POST["nomcrea"], $_POST["contenucrea"]);
					$stmt->execute();

					echo "projet créer";
					$url = "projet.php";
					header("Location: $url", true, 302);
					exit();
				}
			}
			
			echo '<form action="" method="post">
				Nom du projet:
				<input name="nomcrea" type="text" /> <br>
				Description: 
				<input name="contenucrea" type="text" /> <br>
				<input name="crea" type="submit" value = create />	
				</form>';
				
		}
		echo  '<form action="" method="post">
				<input name="deco" type="submit" value = "déconnexion" />
				</form>';
	}
	else {
		$url = "login.php";
		header("Location: $url", true, 302);
		exit();
	}
?>