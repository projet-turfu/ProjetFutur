<!doctype html>
<html lang="fr">
<?php
session_set_cookie_params([
    'httponly' => true,
    'secure'   => false, 
    'samesite' => 'Lax',
]);
session_start();
?>

<head>
    
    <?php
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
                <a href="<?php echo'projet.php?param=1' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm200-190q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-200v-560 560Z"/></svg>
                    <span>Projets</span>
                </a>
            </li>
            <li>
                <a href="projet.php">
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
                <a href="login.php">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                    <span>Déconnexion</span>
                </a>
            </li>
            
        </ul>
        <form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
            <input name="deco" type="submit" value="déconnexion" />
        </form>
		<form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
			<input name="retourtask" type="submit" value = retour />	
            
		</form>
    </nav>
	<section>
        <div class="background">
	
<?php




if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

function check_csrf() {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        die('Requête invalide (CSRF)');
    }
}

function e($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Vérif connexion
if (!isset($_SESSION["connect"]) || !is_numeric($_SESSION["connect"])) {
    session_regenerate_id(true);
    header("Location: login.php", true, 302);
    exit();
}

// Timeout 24 min
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 1440) {
    session_unset();
    session_destroy();
    header("Location: login.php", true, 302);
    exit();
}
$_SESSION['last_activity'] = time();



// Connexion BDD via crepo_db
$dbConf = require __DIR__ . '/config/crepo_db.php';
$mysqli = new mysqli($dbConf['host'], $dbConf['user'], $dbConf['pass'], $dbConf['name']);
if ($mysqli->connect_error) {
    die("Erreur serveur. Réessayez plus tard.");
}
$mysqli->set_charset($dbConf['charset']);


// Vérification utilisateur
$userId = (int)$_SESSION["connect"];
$stmtUser = $mysqli->prepare("SELECT id_user FROM user WHERE id_user = ?");
$stmtUser->bind_param("i", $userId);
$stmtUser->execute();
if ($stmtUser->get_result()->num_rows === 0) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$stmtUser->close();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["deco"])) {
        check_csrf();
        session_unset();
        session_destroy();
        header("Location: login.php", true, 302);
        exit();
    }
    if (isset($_POST["retourtask"])) {
        check_csrf();
        header("Location: projet.php", true, 302);
        exit();
    }
}

$infoMessage  = '';
$errorMessage = '';




$projectName      = $_SESSION["projet"] ?? '';
$currentProjectId = null;
if ($projectName !== '') {
    $stmt = $mysqli->prepare("SELECT id_project FROM project WHERE nom = ?");
    $stmt->bind_param("s", $projectName);
    $stmt->execute();
    $res_id = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($res_id) {
        $currentProjectId = (int)$res_id["id_project"];
    }
}
if ($currentProjectId === null) {
    $errorMessage = "Projet introuvable.";
}




$currentRight = 0;
if ($currentProjectId !== null) {
    $stmt = $mysqli->prepare("SELECT droit FROM project_membre WHERE id_project = ? AND id_user = ?");
    $stmt->bind_param("ii", $currentProjectId, $userId);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($res) {
        $currentRight = (int)$res['droit'];
    } else {
        $errorMessage = "Vous n'êtes pas membre de ce projet.";
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST' && $currentProjectId !== null && $currentRight > 0) {
    check_csrf();



    // Ajout membre 
    if (isset($_POST["add"]) && $currentRight >= 5) {
        $pseudoAdd = trim(substr($_POST["addnom"] ?? '', 0, 50));

        if ($pseudoAdd === '') {
            $errorMessage = "Pseudo vide.";
        } else {
            $stmt = $mysqli->prepare("SELECT id_user FROM user WHERE user = ?");
            $stmt->bind_param("s", $pseudoAdd);
            $stmt->execute();
            $resUser = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$resUser) {
                $errorMessage = "Pseudo introuvable.";
            } else {
                $newUserId = (int)$resUser['id_user'];

                
                $stmt = $mysqli->prepare("SELECT 1 FROM project_membre WHERE id_project = ? AND id_user = ?");
                $stmt->bind_param("ii", $currentProjectId, $newUserId);
                $stmt->execute();
                $exists = $stmt->get_result()->num_rows > 0;
                $stmt->close();

                if ($exists) {
                    $infoMessage = "Utilisateur déjà présent.";
                } else {
                    $defaultRight = 1;
                    $stmt = $mysqli->prepare("INSERT INTO project_membre (id_user, id_project, droit) VALUES (?, ?, ?)");
                    $stmt->bind_param("iii", $newUserId, $currentProjectId, $defaultRight);
                    if ($stmt->execute()) {
                        $infoMessage = "Utilisateur ajouté.";
                    } else {
                        $errorMessage = "Erreur lors de l'ajout.";
                    }
                    $stmt->close();
                }
            }
        }
    }



    // Modification des droits 
    if (isset($_POST["right"]) && $currentRight >= 5) {
        $targetUserId = (int)($_POST["nom"] ?? 0);
        $newRight     = (int)($_POST["droit"] ?? 0);

        if ($targetUserId <= 0 || $newRight <= 0) {
            $errorMessage = "Paramètres invalides.";
        } elseif ($newRight > $currentRight && $currentRight < 9) {
            $errorMessage = "Vous ne pouvez pas donner plus de droits que les vôtres.";
        } else {
            $stmt = $mysqli->prepare("SELECT droit FROM project_membre WHERE id_project = ? AND id_user = ?");
            $stmt->bind_param("ii", $currentProjectId, $targetUserId);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$row) {
                $errorMessage = "Membre introuvable.";
            } else {
                $targetCurrentRight = (int)$row['droit'];

                
                if ($targetUserId !== $userId && $targetCurrentRight >= $currentRight) {
                    $errorMessage = "Vous ne pouvez pas modifier ce membre.";
                } elseif ($targetUserId === $userId && $newRight > $currentRight) {
                    $errorMessage = "Vous ne pouvez pas augmenter vos propres droits au-dessus des vôtres.";
                } else {
                    $stmt = $mysqli->prepare("UPDATE project_membre SET droit = ? WHERE id_project = ? AND id_user = ?");
                    $stmt->bind_param("iii", $newRight, $currentProjectId, $targetUserId);
                    if ($stmt->execute()) {
                        $infoMessage = "Droit mis à jour.";
                    } else {
                        $errorMessage = "Erreur lors de la mise à jour.";
                    }
                    $stmt->close();
                }
            }
        }
    }



    // Suppression membre 
    if (isset($_POST["sup"]) && $currentRight >= 5) {
        $targetUserId = (int)($_POST["supp"] ?? 0);

        if ($targetUserId <= 0) {
            $errorMessage = "Paramètres invalides.";
        } else {
            $stmt = $mysqli->prepare("SELECT droit FROM project_membre WHERE id_project = ? AND id_user = ?");
            $stmt->bind_param("ii", $currentProjectId, $targetUserId);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$row) {
                $errorMessage = "Membre introuvable.";
            } else {
                $targetRight = (int)$row['droit'];

              
                if ($targetUserId === $userId && $currentRight == 9) {
                    $errorMessage = "Un propriétaire ne peut pas se supprimer lui-même du projet.";
                } elseif ($targetUserId !== $userId && $targetRight >= $currentRight) {
                    $errorMessage = "Vous ne pouvez pas supprimer ce membre.";
                } else {
                    $stmt = $mysqli->prepare("DELETE FROM project_membre WHERE id_project = ? AND id_user = ?");
                    $stmt->bind_param("ii", $currentProjectId, $targetUserId);
                    if ($stmt->execute()) {
                        $infoMessage = "Membre supprimé.";
                    } else {
                        $errorMessage = "Erreur lors de la suppression.";
                    }
                    $stmt->close();
                }
            }
        }
    }
}




// Liste des membres
$members = [];
if ($currentProjectId !== null) {
    $stmt = $mysqli->prepare("
        SELECT U.id_user, U.user, M.droit 
        FROM user U 
        JOIN project_membre M ON U.id_user = M.id_user 
        WHERE M.id_project = ?
        ORDER BY U.user
    ");
    $stmt->bind_param("i", $currentProjectId);
    $stmt->execute();
    $members = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>

            <?php if ($errorMessage): ?>
                <p style="color:red;font-weight:bold;"><?= e($errorMessage) ?></p>
            <?php elseif ($infoMessage): ?>
                <p style="color:green;font-weight:bold;"><?= e($infoMessage) ?></p>
            <?php endif; ?>

            <div class="membersList">
                <h1>Liste des membres</h1><br>
                <?php foreach ($members as $m): ?>
                    <div class="membersListItems">
                        <?= e($m['user']) ?><br>
                        Droit: <?= (int)$m['droit'] ?><br>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="membersManagement">
                <?php if ($currentRight >= 5): ?>
                    <h3>Ajouter un membre</h3>
                    <form action="" method="post">
                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                        Identifiant (pseudo):<br>
                        <input name="addnom" type="text" maxlength="50"><br>
                        <input name="add" type="submit" value="Ajouter">
                    </form>
                    <br>

                    <h3>Gérer les droits</h3>
                    <form action="" method="post">
                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

                        <label for="nom">Nom:</label>
                        <select name="nom" id="nom">
                            <option value="">--Choisissez un membre--</option>
                            <?php foreach ($members as $m): ?>
                                <?php
                                $mid    = (int)$m['id_user'];
                                $mRight = (int)$m['droit'];
                                $canSee = ($mRight < $currentRight) || ($mid === $userId);
                                ?>
                                <?php if ($canSee): ?>
                                    <option value="<?= $mid ?>"><?= e($m['user']) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select><br>

                        <label for="droit">Droit:</label>
                        <select name="droit" id="droit">
                            <option value="">--Choisissez un droit--</option>
                            <?php
                            if ($currentRight == 9) {
                                echo '<option value="9">9 propriétaire</option>';
                            }
                            for ($i = $currentRight - 1; $i >= 1; $i--) {
                                if ($i == 1) {
                                    echo '<option value="1">1 simple employé</option>';
                                } else {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            }
                            ?>
                        </select><br>

                        <input name="right" type="submit" value="Confirmer">
                    </form>
                    <br>

                    <h3>Supprimer un membre</h3>
                    <form action="" method="post">
                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

                        <label for="supp">Nom:</label>
                        <select name="supp" id="supp">
                            <option value="">--Choisissez un membre--</option>
                            <?php foreach ($members as $m): ?>
                                <?php
                                $mid    = (int)$m['id_user'];
                                $mRight = (int)$m['droit'];
                                $canSee = ($mRight < $currentRight) || ($mid === $userId);
                                ?>
                                <?php if ($canSee): ?>
                                    <option value="<?= $mid ?>"><?= e($m['user']) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select><br>

                        <input name="sup" type="submit" value="Supprimer">
                    </form>
                <?php endif; ?>

                <br><br>
                <form action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    <input name="retourtask" type="submit" value="Retour">

               <main>
    
			
			
		</div>
	</section>
</main>
</body>

</html>