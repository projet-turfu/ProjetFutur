<?php
	
	session_start();
	if(isset($_SESSION["connect"])){
		
		if(True != isset($_POST["retourtask"])){
		
			$servername = "localhost";
			$username = "phpclient";
			$password = "php@code/1234";
			$database = "crepobd";
			$connect = mysqli_connect($servername, $username, $password, $database);
			$mysqli = new mysqli($servername, $username, $password, $database);
			
			
			$id =  $_SESSION["projet"];
			$idp = $_SESSION["connect"];
			
			$stmt = $mysqli->prepare("select user from user where id_user = (select id_user from project_membre where id_project = (select id_project from project where nom = ?));");
			$stmt->bind_param("s", $id);
			$stmt->execute();
			$res_test = $stmt->get_result();
			
			
			foreach($res_test as $res){
				echo $res["user"]."<br>";
				echo "---------------------------------------------------------<br>";
				
			
			}
			
			$stmt = $mysqli->prepare("select id_user, droit from project_membre where id_project = (select id_project from project where nom = ?);");
			$stmt->bind_param("s", $id);
			$stmt->execute();
			$res_test = $stmt->get_result();
			
			
			
			 $x = 1;
			 
			foreach($res_test as $res){
				if($res["id_user"] == $idp){
					$droit = $res["droit"];
					if($res["droit"] > 5)
						$x = 2;
				}
			}
			
			if($x == 2){
				
				echo '<form action="" method="post">
					<label for="nom-select">Nom:</label>
					
					<select name="nom" id="nom">
					  <option value="">--Please choose an option--</option>';
					  
				
				
				$stmt = $mysqli->prepare("select DISTINCT U.id_user, U.user, droit from user U, project_membre M, project P where U.id_user = M.id_user and M.id_project = P.id_project and P.nom = ?;");
				$stmt->bind_param("i", $id);
				$stmt->execute();
				$res_test = $stmt->get_result();
				
				
				foreach($res_test as $res){
					if($res["droit"] < $droit)
						echo '<option value="'.$res["user"].'">'.$res["user"].'</option>';
					elseif($idp == $res["id_user"])
						echo '<option value="'.$res["user"].'">'.$res["user"].'</option>';
						
					
				}
				echo '</select><br>';
				
						
				echo '<label for="droit-select">Droit:</label>

						<select name="droit" id="pet-select">
						  <option value="">--Please choose an option--</option>';
						  
				$droitT = $droit - 1;  
				if($droit == 9)
						echo '<option value="9">9 propriétaire</option>';
				for ($i = $droitT; $i >= 1; $i--) {
					if($i == 1){
					echo '<option value="'.$i.'">'.$i.' simple employé</option>';
					}
					else{
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				}

				echo '</select><br>
				<input name="membre" type="submit" value = task />
				</form>';
			
				
			}
			
			
			
			

		
		}
		
		else {
			
			$url = "projet.php";
			header("Location: $url", true, 302);
			exit();
		}
		
		echo  '<form action="" method="post">
				<input name="retourtask" type="submit" value = retour />
	
				</form>';
			
	}
	
	else{
		
		$url = "login.php";
		header("Location: $url", true, 302);
		exit();
	}
?>