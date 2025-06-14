<?php
session_start();
$host = "localhost";
$dbname = "Yves_bd";
$username = "root"; // Modifiez selon votre configuration
$password = ""; // Ajoutez votre mot de passe MySQL

$errors = []; // Stockage des erreurs

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // 🔍 1. Vérification des champs vides
    $mail = trim($_POST["mail"]);
    $password = trim($_POST["password"]);

    if (empty($mail) || empty($password)) {
        $errors[] = "Tous les champs doivent être remplis.";
    }

    // 🔍 2. Vérification du format de l'email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse e-mail n'est pas valide.";
    }

    // 🔍 3. Vérification des identifiants dans la base de données
    if (empty($errors)) {
        try {
            $query = "SELECT id, nom_complet, password FROM aboner WHERE mail = :mail";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":mail", $mail);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe haché
            if ($user && password_verify($password, $user["password"])) {
                // Création de session utilisateur
                $_SESSION["user_mail"] = $mail;
                $_SESSION["user_nom"] = $user["nom_complet"];
                $_SESSION["user_id"] = $user["id"];
                
                // Redirection vers la page d'accueil
                header("Location: ../index.php");
                exit();
            } else {
                $errors[] = "Email ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de la connexion : " . $e->getMessage();
        }
    }
}
?>

<!-- Affichage des erreurs -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <form method="post" action="connect.php">
        <h1 class="h3 mb-3 fw-normal">Nous rencontrons des soucis a vous connecter</h1>

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

