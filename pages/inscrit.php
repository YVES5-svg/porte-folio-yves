<?php
session_start();
$host = "localhost";
$dbname = "Yves_bd";
$username = "root"; // À modifier selon votre configuration
$password = ""; // Ajoutez votre mot de passe MySQL

$errors = []; // Tableau pour stocker les erreurs

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // Récupération et nettoyage des données
    $nom_complet = trim($_POST["nom_complet"]);
    $mail = trim($_POST["mail"]);
    $password = trim($_POST["password"]);
// traitement des champs du formulaire
    // ✅ 1. Vérifier si tous les champs sont remplis
    if (empty($nom_complet) || empty($mail) || empty($password)) {
        $errors[] = "Tous les champs doivent être remplis.";
    }
// expression reguliere regex
    // ✅ 2. Vérifier le format du nom (pas de caractère spécial au début)
    if (!preg_match("/^[A-Za-zÀ-ÿ][A-Za-zÀ-ÿ\s'-]*$/", $nom_complet)) {
        $errors[] = "Le nom complet doit commencer par une lettre et ne pas contenir de caractères spéciaux.";
    }

    // ✅ 3. Vérifier le format de l'email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse e-mail n'est pas valide.";
    }
//validation e-mail
    // ✅ 4. Vérifier la complexité du mot de passe
    if (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    // ✅ 5. Si aucune erreur, enregistrer dans la BD
    if (empty($errors)) {
        try {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO aboner (nom_complet, mail, password) VALUES (:nom_complet, :mail, :password)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":nom_complet", $nom_complet);
            $stmt->bindParam(":mail", $mail);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->execute();

            // Création de session utilisateur
            $_SESSION["user_mail"] = $mail;
            $_SESSION["user_nom"] = $nom_complet;

            echo "<script>alert('Bravo ! Vous êtes abonné avec succès. Cliquez sur OK pour vous connecter à votre session.'); window.location.href='connexion.html';</script>";
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
?>

<!-- Affichage des erreurs sur la même page -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <form method="post" action="inscrit.php">
        <h1 class="h3 mb-3 fw-normal">des ereurs lors de la validation du formulaire</h1>

        <!-- Affichage des erreurs -->
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php


