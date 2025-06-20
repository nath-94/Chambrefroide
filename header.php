<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$user = null;
if (isset($_SESSION['id_user'])) {
    $user = [
        'nom' => $_SESSION['nom'] ?? '',
        'prenom' => $_SESSION['prenom'] ?? '',
        'type_utilisateur' => $_SESSION['type_utilisateur'] ?? '',
    ];
}
?>
<header class="main-header">
    <nav class="navbar">
        <a href="accueil.php" class="logo-link">
            <span class="logo-icon">❄️</span>
            <span class="brand-title">Chambre Froide</span>
        </a>
        <div class="nav-links">
            <a href="accueil.php">Accueil</a>
            <a href="faq.php">FAQ</a>
            <a href="contact.php">Contact</a>
            <?php if ($user && $user['type_utilisateur'] === 'Administrateur'): ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
        </div>
        <div class="user-menu">
            <?php if ($user): ?>
                <span class="user-name">👤 <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></span>
                <a href="logout.php" class="logout-btn">Déconnexion</a>
            <?php else: ?>
                <a href="login.php" class="login-btn">Connexion</a>
                <a href="register.php" class="register-btn">Inscription</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
<style>
.main-header {
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 2px 8px rgba(76, 61, 139, 0.08);
    padding: 0;
}
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    padding: 12px 24px;
}
.logo-link {
    display: flex;
    align-items: center;
    text-decoration: none;
}
.logo-icon {
    font-size: 2em;
    margin-right: 10px;
}
.brand-title {
    color: #fff;
    font-size: 1.5em;
    font-weight: bold;
    letter-spacing: 1px;
}
.nav-links {
    display: flex;
    gap: 24px;
}
.nav-links a {
    color: #e0e0ff;
    text-decoration: none;
    font-size: 1.1em;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 8px;
    transition: background 0.2s, color 0.2s;
}
.nav-links a:hover, .nav-links a.active {
    background: rgba(255,255,255,0.18);
    color: #fff;
}
.user-menu {
    display: flex;
    align-items: center;
    gap: 12px;
}
.user-name {
    color: #fff;
    font-weight: 500;
    margin-right: 8px;
}
.logout-btn, .login-btn, .register-btn {
    background: #fff;
    color: #764ba2;
    border: none;
    border-radius: 8px;
    padding: 7px 16px;
    font-weight: bold;
    font-size: 1em;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(76, 61, 139, 0.08);
    transition: background 0.2s, color 0.2s;
}
.logout-btn:hover, .login-btn:hover, .register-btn:hover {
    background: #764ba2;
    color: #fff;
}
@media (max-width: 800px) {
    .navbar {
        flex-direction: column;
        gap: 10px;
        padding: 10px;
    }
    .nav-links {
        gap: 12px;
    }
    .brand-title {
        font-size: 1.1em;
    }
    .logo-icon {
        font-size: 1.3em;
    }
}
</style>
