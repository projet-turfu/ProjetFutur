<!doctype html>
<html lang="fr">

<head>
    
    <?php
        session_start();
        if (isset($_POST["deco"]) or !isset($_SESSION["connect"])) {
            unset($_SESSION["connect"]);
            $url = "login.php";
            header("Location: $url", true, 302);
            exit();
        }
        elseif(isset($_POST["retourtask"])){
            $url = "projet.php";
            header("Location: $url", true, 302);
            exit();
        }
    
    ?>
    <meta charset="utf-8">
    <title>Crepo | Membres</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link href="styles/stylefile.css" rel="stylesheet">
    <script type="text/javascript" src="script/script.js" defer></script>
</head>

<body>
    <nav id="sidebar">
        <ul>
            <li>
                <span class="logo"><img src="images/logoBlack.png" class="logoCrepo">Crepo</span>
                <button onclick=toggleSidebar() id="toggleBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-240 200-480l240-240 56 56-183 184 183 184-56 56Zm264 0L464-480l240-240 56 56-183 184 183 184-56 56Z"/></svg>
                </button>
            </li>
            <li class="active">
                <a href="projet.php">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-246q54-53 125.5-83.5T480-360q83 0 154.5 30.5T760-246v-514H200v514Zm280-194q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm69-80h422q-44-39-99.5-59.5T480-280q-56 0-112.5 20.5T269-200Zm211-320q-25 0-42.5-17.5T420-580q0-25 17.5-42.5T480-640q25 0 42.5 17.5T540-580q0 25-17.5 42.5T480-520Zm0 17Z"/></svg>
                    <span>Profil</span>
                </a>
            </li>
            <li>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm200-190q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-200v-560 560Z"/></svg>
                    <span>Projets</span>
                </a>
            </li>
            <li>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M360-200v-80h480v80H360Zm0-240v-80h480v80H360Zm0-240v-80h480v80H360ZM200-160q-33 0-56.5-23.5T120-240q0-33 23.5-56.5T200-320q33 0 56.5 23.5T280-240q0 33-23.5 56.5T200-160Zm0-240q-33 0-56.5-23.5T120-480q0-33 23.5-56.5T200-560q33 0 56.5 23.5T280-480q0 33-23.5 56.5T200-400Zm0-240q-33 0-56.5-23.5T120-720q0-33 23.5-56.5T200-800q33 0 56.5 23.5T280-720q0 33-23.5 56.5T200-640Z"/></svg>
                    <span>Tâches</span>
                </a>
            </li>
            <li>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M0-240v-63q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 48v65H0Zm240 0v-65q0-32 17.5-58.5T307-410q32-20 76.5-30t96.5-10q53 0 97.5 10t76.5 30q32 20 49 46.5t17 58.5v65H240Zm540 0v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v63H780Zm-455-80h311q-10-20-55.5-35T480-370q-55 0-100.5 15T325-320ZM160-440q-33 0-56.5-23.5T80-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T160-440Zm640 0q-33 0-56.5-23.5T720-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T800-440Zm-320-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-600q0 50-34.5 85T480-480Zm0-80q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560Zm1 240Zm-1-280Z"/></svg>
                    <span>Membres</span>
                </a>
            </li>
            <li class="logOut">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                    <span>Déconnexion</span>
                </a>
            </li>
            
        </ul>
        <form action="" method="post">
            <input name="deco" type="submit" value="déconnexion" />
        </form>
    </nav>




<main>
    <section>
        <div class="background">
			<?php
				
					
						$servername = "localhost";
						$username = "phpclient";
						$password = "php@code/1234";
						$database = "crepobd";
						$connect = mysqli_connect($servername, $username, $password, $database);
						$mysqli = new mysqli($servername, $username, $password, $database);
						
						
						
						$id =  $_SESSION["projet"];
						$idp = $_SESSION["connect"];
						
						$p = 0;
						
						$stmt = $mysqli->prepare("select id_project from project where nom = ?;");
						$stmt->bind_param("s", $id);
						$stmt->execute();
						$res_id = $stmt->get_result();
						
						foreach($res_id as $idpro)
							$id = (int)$idpro["id_project"];
							
						
						
						if(isset($_POST["right"])){
							
							$idr = $_POST["nom"];
							$rig = $_POST["droit"];
							
							$stmt = $mysqli->prepare("UPDATE `project_membre` SET `droit` = ? WHERE id_user = ?;");
							$stmt->bind_param("ii", $rig, $idr);
							$stmt->execute();
						}
						
						
						
						
						
						
						
						$s = 0;
						$b = 0;	
						
						if(isset($_POST["add"])){
								
							$stmt = $mysqli->prepare("select * from user where user = ?;" );
							$stmt->bind_param("s", $_POST["addnom"]);
							$stmt->execute();
							$resultat = $stmt->get_result();
							
							
							
							foreach ($resultat as $x) {
								if($x["user"]==$_POST["addnom"]){
									$per = $x["id_user"];
									$b = 1;
									break;
								}
							}
							
							if($b != 0){
								
								$stmt2 = $mysqli->prepare("select * from project_membre where id_project = ?;" );
								$stmt2->bind_param("i", $id);
								$stmt2->execute();
								$resif = $stmt2->get_result();
								
								foreach($resif as $y){
								
									if($per == $y["id_user"]){
										$p = 1;
									}
								}
							}

						}
						
						
						
						
						
						
						if(isset($_POST["sup"])){
							
							
							$stmt = $mysqli->prepare("select * from user where user = ?;" );
							$stmt->bind_param("s", $_POST["supp"]);
							$stmt->execute();
							$resultat = $stmt->get_result();
							
							$b = 0;
							
							foreach ($resultat as $x) {
								if($x["user"]==$_POST["supp"]){
									$per = $x["id_user"];
									$b = 1;
									break;
								}
							}
							
							if($b != 0){
								
								$stmt2 = $mysqli->prepare("select * from project_membre where id_project = ?;" );
								$stmt2->bind_param("i", $id);
								$stmt2->execute();
								$resif = $stmt2->get_result();
								
								foreach($resif as $y){
								
									if($per == $y["id_user"]){
										$p = 1;
									}
								}
							}
							
							$stmt = $mysqli->prepare("DELETE FROM `project_membre` WHERE id_user = ? and id_project = ?;");
							$stmt->bind_param("ii", $_POST["supp"], $id);
							$stmt->execute();
							
							$s = 1;
						}
						
						
						
						
						
						
						
						
						if(($p == 0) and $id != NULL and isset($per)){
							$stmt = $mysqli->prepare("Insert into project_membre values (?, ?, ?);");
							$default = 1;
							$stmt->bind_param("iii",$per , $id, $default);
							$stmt->execute(); 
						}
						
						$stmt = $mysqli->prepare("select U.user as user, droit  from user U, project_membre P where U.id_user = P.id_user and id_project = ? ;");
						$stmt->bind_param("i", $id);
						$stmt->execute();
						$res_test = $stmt->get_result();
						
						
						
						echo'<div class="membersList">';
						echo'<h1>Liste des membres</h1><br>';
						foreach($res_test as $res){
							
							echo'<div class="membersListItems">';
								echo $res["user"]."<br>".$res["droit"];
								//echo $res["droit"]."<br>";
								echo "<br>";
							echo'</div>';
							
						
						}
						echo'</div>';
						echo "<br><br>";
						
						echo'<div class="membersManagement">';
						if(isset($_POST["add"])){
							if($b == 0)
								echo "pseudo introuvable<br>";
							
							elseif($p == 0)
								echo "utilisateur ajoutée<br>";
							else
								echo "utilisateur déjà présent<br>";
						}
							
							
						
						
						
						
						
						
						$stmt = $mysqli->prepare("select id_user, droit from project_membre where id_project = ?;");
						$stmt->bind_param("i", $id);
						$stmt->execute();
						$res_test = $stmt->get_result();
						
						$x = 1;
						
						foreach($res_test as $res){
							if($res["id_user"] == $idp){
								$droit = $res["droit"];
								if($res["droit"] >= 5)
									$x = 2;
							}
						}
						
						if($x == 2){
							
							echo 'Ajouté un membre: <br>
						<form action="" method="post">
						identifiant:
						<input name="addnom" type="text" /> <br>
						<input name="add" type="submit" value="Ajouter" />
						</form>';
							
							
							echo "<br><br>";
							
							
							
							
							
							
							
							
							
							
							
							
							echo 'Gérer les droits: <br><form action="" method="post">
								<label for="nom-select">Nom:</label>
								
								<select name="nom" id="nom">
								<option value="">--Choisissez une option--</option>';
								
							
							$stmt = $mysqli->prepare("select DISTINCT U.id_user, U.user, droit from user U, project_membre M where U.id_user = M.id_user and id_project = ?;");
							$stmt->bind_param("i", $id);
							$stmt->execute();
							$res_test = $stmt->get_result();
							
							
							foreach($res_test as $res){
								if($res["droit"] < $droit)
									echo '<option value="'.$res["id_user"].'">'.$res["user"].'</option>';
								elseif($idp == $res["id_user"])
									echo '<option value="'.$res["id_user"].'">'.$res["user"].'</option>';
									
								
							}
							
							echo '</select><br>';
							
									
							echo '<label for="droit-select">Droit:</label>

									<select name="droit" id="pet-select">
									<option value="">--Choisissez une option--</option>';
									
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
							<input name="right" type="submit" value = "Confirmer" />
							</form>';
						
						}
						
						if($s == 1)
								echo "Membre supprimé<br>";
							
							echo ' Supprimer un membre: <br><form action="" method="post">
								<label for="nom-select">Nom:</label>
								
								<select name="supp" id="supp">
								<option value="">--Choisissez une option--</option>';
								
							
							$stmt = $mysqli->prepare("select DISTINCT U.id_user, U.user, droit from user U, project_membre M where U.id_user = M.id_user and id_project = ?;");
							$stmt->bind_param("i", $id);
							$stmt->execute();
							$res_test = $stmt->get_result();
							
							
							foreach($res_test as $res){
								if($res["droit"] < $droit)
									echo '<option value="'.$res["id_user"].'">'.$res["user"].'</option>';
								elseif($idp == $res["id_user"])
									echo '<option value="'.$res["id_user"].'">'.$res["user"].'</option>';
									
								
							}
							
							echo '</select><br>
							<input name="sup" type="submit" value = "Supprimer" />
							</form>';
							
							echo "<br><br>";
							echo'</div>';
					
					
					echo  '<form action="" method="post">
							<input name="retourtask" type="submit" value = retour />
				
							</form>';
						
				
			?>
		</div>
	</section>
</main>
</body>

</html>