<!doctype html>
<html lang="fr">
<head>
<?php

session_set_cookie_params([
    'httponly' => true,
    'secure'   => false, // true si HTTPS
    'samesite' => 'Lax',
]);
session_start();


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

// TIMEOUT 24min 
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 1440) {
    session_unset(); session_destroy();
    header("Location: login.php", true, 302); exit();
}
$_SESSION['last_activity'] = time();

// VÉRIF CONNEXION
if (!isset($_SESSION["connect"]) || !is_numeric($_SESSION["connect"]) || $_SESSION["connect"] <= 0) {
    session_regenerate_id(true);
    header("Location: login.php", true, 302); exit();
}

// CONNEXION BDD SÉCURISÉE
$dbConf = require 'config/crepo_db.php';
$mysqli = new mysqli($dbConf['host'], $dbConf['user'], $dbConf['pass'], $dbConf['name']);
if ($mysqli->connect_error) {
    $dbError = "Erreur serveur. Réessayez plus tard."; $mysqli = null;
} else {
    $mysqli->set_charset('utf8mb4');
    // VÉRIF USER EN BDD 
    $stmtUser = $mysqli->prepare("SELECT id_user FROM user WHERE id_user = ?");
    $stmtUser->bind_param("i", $_SESSION["connect"]);
    $stmtUser->execute();
    if ($stmtUser->get_result()->num_rows == 0) {
        session_regenerate_id(true); header("Location: login.php", true, 302); exit();
    }
}

// FONCTIONS SÉCURITÉ
function e($string) { return htmlspecialchars($string, ENT_QUOTES, 'UTF-8'); }
function check_csrf() { return isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']); }

// ACTIONS SÉCURISÉES AVEC CSRF
if (isset($_POST["deco"]) && check_csrf()) {
    session_unset(); session_destroy(); header("Location: login.php", true, 302); exit();
}
if (isset($_POST['membre']) && check_csrf()) {
    $_SESSION["crea"] = 1; header("Location: membre.php", true, 302); exit();
}
elseif(isset($_GET["param"])) {
    $_SESSION["crea"] = 2; header("Location: projet.php", true, 302); exit();
}
?>
<meta charset="utf-8">
<title>Crepo | Projets</title>
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
            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
            <input name="deco" type="submit" value="Déconnexion" />
        </form>
        <form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
            <input name="retourtask" type="submit" value="Retour" />
            <input name="membre" type="submit" value="Membre" />
        </form>
    </nav>

 <main>
        <section>
            <div class="background">
                <div class="projectsList">
                
                    <?php

                    

                    if (isset($_SESSION["connect"])) {

                        $servername = "localhost";
                        $username   = "phpclient";
                        $password   = "php@code/1234";
                        $database   = "crepobd";
                        $connect    = mysqli_connect($servername, $username, $password, $database);
                        $mysqli     = new mysqli($servername, $username, $password, $database);

                        $requete = "select nom from project;";
                        $resultat = $mysqli->query($requete);
						
						$stmt = $mysqli->prepare("select id_project from project where nom = ?;");
						$stmt->bind_param("s", $_POST["nomcrea"]);
						$stmt->execute();
						$idPro = $stmt->get_result();

						foreach ($idPro as $idPr) {

							$projectId = (int)$idPr["id_project"];
						}

                        if (isset($_SESSION["crea"]))
                            $_SESSION["crea"] = 1;
                        else
                            $_SESSION["crea"] = 2;

                        $p = 0;

                        if (isset($_POST["projet"]))
                            $_SESSION["projet"] = $_POST["projet"];

                        //// faut que le if fonctionne pas pour la redif projet
                        if ((isset($_SESSION["projet"]) || $_SESSION["crea"] == 1) && !isset($_POST["retourtask"])) {

                            $nomp = $_SESSION["projet"];

                            $stmt = $mysqli->prepare("select Distinct T.id_task, B.id_block from task T, block B where B.id_block = T.status and T.id_project in (select id_project from project where nom =  ?) ;" );
                            $stmt->bind_param("s", $nomp);
                            $stmt->execute();
                            $resultat = $stmt->get_result();

                            $stmt2 = $mysqli->prepare("select max(id_block) as 'max' from block where id_project in (select id_project from project where nom =?) ;" );
                            $stmt2->bind_param("s", $nomp);
                            $stmt2->execute();
                            $max = $stmt2->get_result();
                            $maxi = 0;
                            
                            foreach ($max as $x) {
                                $maxi = $x['max'];
                            }
                            
                            $stmt = $mysqli->prepare("UPDATE `task` SET `status` = ? WHERE id_task = ?;");
                            
                            foreach ($resultat as $x) {
                                if(isset($_POST["up".$x["id_task"]])){
                                    if($x["id_block"] < $maxi){
                                        $stat = $x["id_block"]+1;
                                        $stmt->bind_param("is", $stat, $x["id_task"]);
                                        $stmt->execute();
                                    }
                                    
                                }
                                elseif(isset($_POST["down".$x["id_task"]])){
                                    if($x["id_block"] > 0){
                                        $stat = $x["id_block"]-1;
                                        $stmt->bind_param("is", $stat, $x["id_task"]);
                                        $stmt->execute();
                                    }
                                }
                                
                            }

                    
                    $stmt = $mysqli->prepare("SELECT DISTINCT id_task, priority 
                                              FROM task 
                                              WHERE id_project IN (SELECT id_project FROM project WHERE nom = ?)");
                    $stmt->bind_param("s", $nomp);
                    $stmt->execute();
                    $resultat = $stmt->get_result();

                    $stmt2 = $mysqli->prepare("SELECT MAX(priority) AS max  
                                               FROM task 
                                               WHERE id_project IN (SELECT id_project FROM project WHERE nom = ?)");
                    $stmt2->bind_param("s", $nomp);
                    $stmt2->execute();
                    $max = $stmt2->get_result();
                    $maxi = 0;
                    foreach ($max as $x) {
                        $maxi = (int)$x['max'];
                    }

                    $stmt = $mysqli->prepare("UPDATE task SET priority = ? WHERE id_task = ?");

                    foreach ($resultat as $x) {
                        $idTask = (int)$x["id_task"];
                        $prio   = (int)$x["priority"];

                        if (isset($_POST["prioup".$idTask]) && check_csrf()) {
                            $stat = $prio + 1;
                            $stmt->bind_param("ii", $stat, $idTask);
                            $stmt->execute();
                        }
                        elseif (isset($_POST["priodown".$idTask]) && check_csrf()) {
                            if ($prio > 0) {
                                $stat = $prio - 1;
                                $stmt->bind_param("ii", $stat, $idTask);
                                $stmt->execute();
                            }
                        }
                    }

                    
                    if (isset($_POST["doss"]) && check_csrf()) {
                        $nomDoss = filter_input(INPUT_POST, "nomdoss", FILTER_SANITIZE_STRING);
                        if (!empty($nomDoss)) {
							$maxiprio = $maxi + 1;
                            $stmt = $mysqli->prepare("insert into block values (?, ?, ?)");
                            $stmt->bind_param("iis", $projectId, $maxiprio, $nomDoss);
                            $stmt->execute();
							
                            $res_rec = $stmt->get_result();

                            foreach ($res_rec as $res) {
								echo "<p>
									<form action=\"\" method=\"post\">
										<input type=\"hidden\" name=\"csrf_token\" value=\"" . e($csrfToken) . "\">
										<input name=\"projet\" type=\"submit\" value=\"" . e($res["nom"]) . "\" /><br>
										" . e($res["contenu"]) . "
									</form><br></p>";
}

                        }
                    }

                    // CRÉATION TÂCHE 
                    $stmt = $mysqli->prepare("SELECT id_project FROM project WHERE nom = ?");
                    $stmt->bind_param("s", $nomp);
                    $stmt->execute();
                    $res_rec = $stmt->get_result();

                    foreach ($res_rec as $res) {
                        $id = (int)$res["id_project"];

                        if (isset($_POST["prio"]) &&
                            isset($_POST["contenu"]) &&
                            isset($_POST["nom"]) &&
                            isset($_POST["start"]) &&
                            isset($_POST["end"]) &&
                            check_csrf()) {

                            $contenuf = filter_input(INPUT_POST, "contenu", FILTER_SANITIZE_STRING);
                            $nomf     = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_STRING);
                            $priof    = (int)$_POST["prio"];
                            $start    = $_POST["start"];
                            $end      = $_POST["end"];

                            if (!empty($contenuf) && !empty($start) && !empty($end) && !empty($priof) && !empty($nomf)) {
                                $status = 0;
                                $stmtTask = $mysqli->prepare(
                                    "INSERT INTO task (id_project, nom, contenu, status, priority, date_start, date_end)
                                     VALUES (?, ?, ?, ?, ?, ?, ?)"
                                );
                                $stmtTask->bind_param("ississs", $id, $nomf, $contenuf, $status, $priof, $start, $end);
                                $stmtTask->execute();
                            }
                        }
                    }

                   
                    $stmt = $mysqli->prepare("SELECT * FROM block WHERE id_project IN (SELECT id_project FROM project WHERE nom = ?) ORDER BY id_block");
                    $stmt->bind_param("s", $nomp);
                    $stmt->execute();
                    $resultat = $stmt->get_result();

                    foreach ($resultat as $x) {
                        echo '<div class="item">';
                        $status = (int)$x["id_block"];
                        $nomB   = e($x["nom"]);
                        echo "<h2>$nomB</h2>";

                        $stmt = $mysqli->prepare("SELECT * FROM task WHERE id_project IN (SELECT id_project FROM project WHERE nom = ?) AND status = ? ORDER BY priority DESC");
                        $stmt->bind_param("si", $nomp, $status);
                        $stmt->execute();
                        $resultat2 = $stmt->get_result();

                        foreach ($resultat2 as $res) {

                            echo '<form action="" method="post">
                                    <input type="hidden" name="csrf_token" value="' . e($csrfToken) . '">
                                    <input name="prioup'.$res["id_task"].'" type="submit" value="^" />
                                  </form>';

                            echo "Nom de la tâche: " . e($res["nom"]) . "<br>";

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

                            echo "Description: " . e($res["contenu"]) . "<br>";
                            echo "date de début: " . e($res["date_start"]) . "<br>";
                            echo "date de fin: " . e($res["date_end"]) . "<br>";
                            echo "Personne travaillant dessus: <br>";

                            $task = (int)$res["id_task"];
                            $stmt = $mysqli->prepare("SELECT user FROM user WHERE id_user IN (SELECT id_user FROM membre_Task WHERE id_task = ?) ORDER BY user ASC");
                            $stmt->bind_param("i", $task);
                            $stmt->execute();
                            $res_per = $stmt->get_result();

                            foreach ($res_per as $per)
                                echo "-" . e($per["user"]) . "<br>";

                            echo '<form action="" method="post">
                                    <input type="hidden" name="csrf_token" value="' . e($csrfToken) . '">
                                    <input name="down'.$res["id_task"].'" type="submit" value="<" />
                                    <input name="up'.$res["id_task"].'" type="submit" value=">" />
                                  </form>';

                            echo '<form action="" method="post">
                                    <input type="hidden" name="csrf_token" value="' . e($csrfToken) . '">
                                    <input name="priodown'.$res["id_task"].'" type="submit" value="v" />
                                  </form>';
                        }
                        echo "</div>";
                    }

                    // FORMULAIRES CRÉATION
                    echo 'Création de dossier: <br>
                          <form action="" method="post">
                              <input type="hidden" name="csrf_token" value="' . e($csrfToken) . '">
                              Nom du dossier:
                              <input name="nomdoss" type="text" /> <br>
                              <input name="doss" type="submit" value="create" />
                          </form>';

                    echo 'Création de tâche: <br>
                          <form action="" method="post">
                              <input type="hidden" name="csrf_token" value="' . e($csrfToken) . '">
                              Nom:
                              <input name="nom" type="text" /> <br>
                              Contenu: 
                              <input name="contenu" type="text" /> <br>
                              <label for="prio-select">Priorité:</label>
                              <select name="prio" id="prio-select">
                                  <option value="">--Please choose an option--</option>
                                  <option value="11">Extrème</option>
                                  <option value="9">Très Haute</option>
                                  <option value="7">Haute</option>
                                  <option value="5">Moyenne</option>
                                  <option value="3">Basse</option>
                                  <option value="1">Très Basse</option>
                              </select><br>
                              Date début:
                              <input name="start" type="date" /> <br>
                              Date fin:
                              <input name="end" type="date" /> <br>
                              <input name="task" type="submit" value="task" />
                          </form>';

                    echo '<form action="" method="post">
                              <input type="hidden" name="csrf_token" value="' . e($csrfToken) . '">
                              <input name="retourtask" type="submit" value="Retour" />
                              <input name="membre" type="submit" value="Membre" />
                          </form>';

                } else {
                    
                
                unset($_SESSION["crea"]);

                            $id = (int)$_SESSION["connect"];

                            $stmt = $mysqli->prepare("select nom, contenu from project where id_project in (select id_project from project_membre where id_user = ?);");
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $res_test = $stmt->get_result();

                            foreach ($res_test as $res) {
                                echo "<p>";
                                echo '
                                <form action="" method="post">
                                    <input name="projet" type="submit" value="' . $res["nom"] . '" /><br>
                                    ' . $res["contenu"] . '
                                </form><br></p>';
                            }

                            $x = 0;

                            if (isset($_POST["crea"]) && $_POST["crea"] == "create") {

                                $stmt = $mysqli->prepare("select nom from project;");
                                $stmt->execute();
                                $res_rec = $stmt->get_result();

                                $contenuc = $_POST["contenucrea"];
                                $nomc = $_POST["nomcrea"];

                                foreach ($res_rec as $res) {
                                    if ($nomc == $res["nom"]) {
                                        echo "information invalide";
                                        $x = 1;
                                    }
                                }
                            }

                            if (isset($_POST['retourtask'])) {
                                unset($_POST['retourtask']);
                                unset($_SESSION["projet"]);
                            }

                            

                            elseif ($x == 0 && !empty($_POST["nomcrea"]) && !empty($_POST["contenucrea"])) {

                                $stmt = $mysqli->prepare("INSERT INTO `project` (`nom`, `contenu`) VALUES (?, ?);");
                                $stmt->bind_param("ss", $_POST["nomcrea"], $_POST["contenucrea"]);
                                $stmt->execute();

                                $stmt = $mysqli->prepare("select id_project from project where nom = ?;");
                                $stmt->bind_param("s", $_POST["nomcrea"]);
                                $stmt->execute();
                                $idPro = $stmt->get_result();

                                foreach ($idPro as $idPr) {

                                    $projectId = (int)$idPr["id_project"];
                                    $role = 9;

                                    $stmt = $mysqli->prepare("INSERT INTO project_membre VALUES (?, ?, ?)");
                                    $stmt->bind_param("iii", $id, $projectId, $role);
                                    $stmt->execute();

                                    $blocks = [
                                        [0, "Futur"],
                                        [1, "En cours"],
                                        [2, "Fini"]
                                    ];

                                    foreach ($blocks as $block) {
                                        $stmt = $mysqli->prepare("INSERT INTO block VALUES (?, ?, ?)");
                                        $stmt->bind_param("iis", $projectId, $block[0], $block[1]);
                                        $stmt->execute();
                                    }
                                }
                            }
                            echo'<div class="managementItems">';
                            echo '
                            <form action="" method="post">
                                Nom du projet:
                                <input name="nomcrea" type="text" /> <br>
                                Description:
                                <input name="contenucrea" type="text" /> <br>
                                <input name="crea" type="submit" value="Créer" />
                            </form>';
                            echo'</div>';
                        }

                    
                    }
                    echo '
                    <form action="" method="post">
                        <input name="deco" type="submit" value="Déconnexion" />
                    </form>';
            ?>
                
            </div>
        </section>
        
    </main>
</body>

</html>