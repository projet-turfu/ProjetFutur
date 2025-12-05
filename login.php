<?php
session_set_cookie_params([
    'httponly' => true,
    'secure'   => false, 
    'samesite' => 'Lax',
]);
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

$error       = '';
$success     = '';
$maxAttempts = 5;
$lockoutTime = 60;

// Anti-bruteforce
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt']   = time();
}
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}

// Timeout d'inactivité (SEULEMENT si POST pour éviter destruction prématurée)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (time() - $_SESSION['last_activity']) > 1800) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION['last_activity'] = time();

$dbConf = require __DIR__ . '/config/crepo_db.php';

// Connexion BDD via crepo_db
$mysqli = new mysqli($dbConf['host'], $dbConf['user'], $dbConf['pass'], $dbConf['name']);
if ($mysqli->connect_error) {
    die("Erreur serveur.");
}
$mysqli->set_charset($dbConf['charset']);

function check_csrf() {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        return false;
    }
    return true;
}

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Navigation boutons SANS CSRF
    if (isset($_POST['inscription']) || isset($_POST['connexion'])) {
        // Rien à traiter, juste afficher le bon formulaire
    }
    // VRAIS formulaires avec CSRF
    elseif (isset($_POST['register']) || isset($_POST['login'])) {
        if (!check_csrf()) {
            $error = 'Requête invalide.';
        } else {
            // Inscription
            if (isset($_POST['register'])) {
                $pseudo          = trim(substr($_POST['pseudo'] ?? '', 0, 50));
                $email           = trim(substr($_POST['email'] ?? '', 0, 100));
                $passwordRaw     = $_POST['password'] ?? '';
                $passwordConfirm = $_POST['password_confirm'] ?? '';

                if (empty($pseudo) || strlen($pseudo) < 3) {
                    $error = "Pseudo invalide (3-50 caractères).";
                } elseif (empty($email) || empty($passwordRaw) || empty($passwordConfirm)) {
                    $error = "Tous les champs obligatoires.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Format email invalide.";
                } elseif ($passwordRaw !== $passwordConfirm) {
                    $error = "Mots de passe différents.";
                } elseif (!preg_match('/^(?=.*\W).{8,}$/', $passwordRaw)) {
                    $error = "Mot de passe faible (8+ caractères, 1 spécial).";
                } else {
                    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM user WHERE user = ? OR email = ?");
                    $stmt->bind_param("ss", $pseudo, $email);
                    $stmt->execute();
                    $stmt->bind_result($count);
                    $stmt->fetch();
                    $stmt->close();

                    if ($count > 0) {
                        $error = "Identifiants déjà utilisés.";
                    } else {
                        $hash = password_hash($passwordRaw, PASSWORD_DEFAULT);
                        $stmtIns = $mysqli->prepare("INSERT INTO user (user, password, email) VALUES (?, ?, ?)");
                        $stmtIns->bind_param("sss", $pseudo, $hash, $email);
                        if ($stmtIns->execute()) {
                            $success = "Inscription réussie. Vous pouvez vous connecter.";
                        } else {
                            $error = "Erreur inscription.";
                        }
                        $stmtIns->close();
                    }
                }
            }

            // Connexion 
            if (isset($_POST['login'])) {
                if ($_SESSION['login_attempts'] >= $maxAttempts && (time() - $_SESSION['last_attempt']) < $lockoutTime) {
                    $remaining = $lockoutTime - (time() - $_SESSION['last_attempt']);
                    $error = "Trop de tentatives. Réessayez dans {$remaining}s.";
                } else {
                    $pseudo      = trim(substr($_POST['pseudo'] ?? '', 0, 50));
                    $passwordRaw = $_POST['password'] ?? '';

                    if (empty($pseudo) || empty($passwordRaw)) {
                        $error = "Champs obligatoires.";
                        $_SESSION['login_attempts']++;
                        $_SESSION['last_attempt'] = time();
                    } else {
                        $stmt = $mysqli->prepare("SELECT id_user, password FROM user WHERE user = ?");
                        $stmt->bind_param("s", $pseudo);
                        $stmt->execute();
                        $stmt->bind_result($idUser, $hash);

                        if ($stmt->fetch() && password_verify($passwordRaw, $hash)) {
                            session_regenerate_id(true);
                            $_SESSION['connect']        = $idUser;
                            $_SESSION['login_attempts'] = 0;
                            header("Location: projet.php");
                            exit();
                        } else {
                            $_SESSION['login_attempts']++;
                            $_SESSION['last_attempt'] = time();
                            $error = "Identifiants incorrects.";
                        }
                        $stmt->close();
                    }
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Crepo | Connexion</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link href="styles/styleLogin.css" rel="stylesheet">
</head>
<body>
<main>
    <div class="wrapper">
        <h1><img src="images/logoBlack.png" class="logoCrepo">Crepo</h1>
        <hr>
        <div class="infoInput">
            <?php if (!empty($error)): ?>
                <p style="color:red;font-weight:bold;"><?= e($error) ?></p>
            <?php elseif (!empty($success)): ?>
                <p style="color:green;font-weight:bold;"><?= e($success) ?></p>
            <?php endif; ?>

            <?php if (isset($_POST['inscription']) || (isset($_POST['register']) && empty($success))): ?>
                <!-- FORMULAIRE INSCRIPTION -->
                <form action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    Pseudo<br>
                    <input class="inputBox" name="pseudo" value="<?= e($_POST['pseudo'] ?? '') ?>" placeholder="Choisissez un pseudo" required><br>
                    Email<br>
                    <input class="inputBox" name="email" type="email" value="<?= e($_POST['email'] ?? '') ?>" placeholder="Choisissez un email" required><br>
                    Password<br>
                    <input class="inputBox" name="password" type="password" placeholder="Choisissez un password" required><br>
                    Confirm<br>
                    <input class="inputBox" name="password_confirm" type="password" placeholder="Confirmez votre password" required><br>
                    <input class="finalButton" name="register" type="submit" value="Valider">
                </form>
                <br><hr>
                <form class="choiceButtons" action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    <h3>ou</h3><br>
                    <input class="loginButton" name="connexion" type="submit" value="Se connecter">
                </form>

            <?php elseif (isset($_POST['connexion']) || isset($_POST['login']) || !empty($success)): ?>
                <!-- FORMULAIRE CONNEXION -->
                <form action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    Pseudo<br>
                    <input class="inputBox" name="pseudo" value="<?= e($_POST['pseudo'] ?? '') ?>" placeholder="Saisissez votre pseudo" required><br>
                    Password<br>
                    <input class="inputBox" name="password" type="password" placeholder="Saisissez votre password" required><br>
                    <input class="finalButton" name="login" type="submit" value="Continuer">
                </form>
                <br><hr>
                <form class="choiceButtons" action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    <h3>ou</h3><br>
                    <input class="signinButtonBottom" name="inscription" type="submit" value="S'inscrire">
                </form>

            <?php else: ?>
                <!-- CHOIX INITIAL -->
                <form class="choiceButtons" action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    <input class="signinButton" name="inscription" type="submit" value="S'inscrire">
                    <h3>ou</h3>
                    <input class="loginButton" name="connexion" type="submit" value="Se connecter">
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php
if (isset($mysqli)) {
    $mysqli->close();
}
?>
</body>
</html>
