<?php
require_once 'config.php';
session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: accueil.php");
    exit();
}

$message = '';

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $message = "✅ Inscription réussie. Vous pouvez maintenant vous connecter.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['type_utilisateur'] = $user['type_utilisateur'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];

        header("Location: accueil.php");
        exit();
    } else {
        $message = "❌ Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RooMeUp</title>
    <link rel="stylesheet" href="login.css">
  
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                eyeIcon.textContent = '👁️';
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Chambre froide</h1>
        <p>Vos données en quelques clics !</p>
    </header>
    <main>
        <div class="login-container">
            <h2>Connexion</h2>
            <?php if (!empty($message)): ?>
                <p class="login-message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <input type="text" name="email" placeholder="Email" required>
                <div class="password-field">
                    <input type="password" name="mot_de_passe" id="password" placeholder="Mot de passe" required>
                    <span id="eye-icon" onclick="togglePasswordVisibility()">👁️</span>
                </div>
                <button type="submit">Se connecter</button>
            </form>
            <a href="register.php">Nouveau membre ? S'inscrire</a>
        </div>
    </main>

    <!-- <?php include 'includes/footer.php'; ?> -->
</body>
</html>
