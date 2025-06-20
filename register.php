<?php
require_once 'config.php';
session_start();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $mot_de_passe2 = $_POST['mot_de_passe2'] ?? '';
    $type_utilisateur = $_POST['type_utilisateur'] ?? '';

    if (empty($nom)) $errors[] = "Le nom est requis.";
    if (empty($prenom)) $errors[] = "Le prénom est requis.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide.";
    if (empty($mot_de_passe) || strlen($mot_de_passe) < 6) $errors[] = "Le mot de passe doit faire au moins 6 caractères.";
    if ($mot_de_passe !== $mot_de_passe2) $errors[] = "Les mots de passe ne correspondent pas.";
    if ($type_utilisateur !== 'Employé' && $type_utilisateur !== 'Administrateur') $errors[] = "Type d'utilisateur invalide.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id_user FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) $errors[] = "Cet email est déjà utilisé.";
    }

    if (empty($errors)) {
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, type_utilisateur) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$nom, $prenom, $email, $hash, $type_utilisateur])) {
            $success = "Inscription réussie ! Vous pouvez vous connecter.";
        } else {
            $errors[] = "Erreur lors de l'inscription.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - RooMeUp</title>
    <link rel="stylesheet" href="login.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }
        header {
            text-align: center;
            padding: 30px 20px 10px;
            color: white;
        }
        .register-container {
            max-width: 430px;
            margin: 40px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 32px rgba(76, 61, 139, 0.13);
            padding: 36px 38px 28px 38px;
            animation: fadeIn 0.7s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: none;}
        }
        .register-container h2 {
            margin-bottom: 22px;
            color: #4F378A;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .register-container .error {
            color: #b00020;
            margin-bottom: 10px;
            background: #ffeaea;
            border-radius: 6px;
            padding: 7px 10px;
            font-size: 0.98em;
        }
        .register-container .success {
            color: #fff;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 6px;
            padding: 10px 12px;
            margin-bottom: 14px;
            font-weight: 500;
        }
        .register-container label {
            display: block;
            text-align: left;
            margin-bottom: 7px;
            margin-top: 16px;
            color: #4F378A;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"],
        .register-container select {
            width: 100%;
            padding: 13px 12px;
            border-radius: 8px;
            border: 1.5px solid #d1d5db;
            margin-bottom: 2px;
            font-size: 1em;
            background: #f7f7fa;
            transition: border-color 0.2s;
        }
        .register-container input:focus,
        .register-container select:focus {
            border-color: #764ba2;
            outline: none;
            background: #f0f0ff;
        }
        .register-container select {
            margin-bottom: 18px;
        }
        .register-container button {
            width: 100%;
            padding: 13px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 22px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(76, 61, 139, 0.08);
            transition: background 0.2s, transform 0.2s;
        }
        .register-container button:hover {
            background: linear-gradient(90deg, #764ba2, #667eea);
            transform: translateY(-2px) scale(1.02);
        }
        .register-container a {
            display: block;
            margin-top: 18px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .register-container a:hover {
            color: #4F378A;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Chambre froide</h1>
        <p>Inscrivez-vous pour accéder au monitoring</p>
    </header>
    <main>
        <div class="register-container">
            <h2>Inscription</h2>
            <?php foreach ($errors as $e): ?>
                <div class="error"><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
            <?php if ($success): ?>
                <div class="success"><?= htmlspecialchars($success) ?></div>
                <a href="login.php">Se connecter</a>
            <?php else: ?>
            <form method="post" action="">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" required value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">

                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" required value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">

                <label for="email">Email</label>
                <input type="email" name="email" id="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" required>

                <label for="mot_de_passe2">Confirmer le mot de passe</label>
                <input type="password" name="mot_de_passe2" id="mot_de_passe2" required>

                <label for="type_utilisateur">Type d'utilisateur</label>
                <select name="type_utilisateur" id="type_utilisateur" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="Employé" <?= (($_POST['type_utilisateur'] ?? '') === 'Employé') ? 'selected' : '' ?>>Employé</option>
                    <option value="Administrateur" <?= (($_POST['type_utilisateur'] ?? '') === 'Administrateur') ? 'selected' : '' ?>>Administrateur</option>
                </select>

                <button type="submit">S'inscrire</button>
            </form>
            <a href="login.php">Déjà inscrit ? Se connecter</a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>