<?php
$photoUrl = $user['photoUrl'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil - Gardiennage d'Animaux</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
</head>
<body>
<?php include(__DIR__ . '/../includes/header.php'); ?>

<div class="loginContainer">
    <h1>Mon Profil</h1>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($photoUrl): ?>
        <div class="profil-photo">
            <img src="<?= htmlspecialchars($photoUrl) ?>" alt="Photo de profil" height="100">
        </div>
    <?php endif; ?>

    <form action="/profile" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="photo">Photo de Profil</label>
            <label for="photo" class="custom-file-label">Choisir une image</label>
            <span id="file-name">Aucune image sélectionnée</span>
            <input type="file" name="photo" id="photo" accept="image/*">
        </div>

        <button type="submit">Sauvegarder</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const input = document.getElementById("photo");
        const fileName = document.getElementById("file-name");
        const form = document.querySelector("form");
        const nomInput = document.getElementById("nom");
        const prenomInput = document.getElementById("prenom");

        input.addEventListener("change", () => {
            fileName.textContent = input.files.length > 0 ? input.files[0].name : "Aucune image sélectionnée";
        });

        form.addEventListener("submit", (event) => {
            if (!nomInput.value.trim() || !prenomInput.value.trim()) {
                event.preventDefault();
                alert("Veuillez remplir les champs Nom et Prénom.");
            }
        });
    });
</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>
