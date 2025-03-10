<?php

// Inclut le fichier d'initialisation qui charge les configurations essentielles
// Ce fichier peut contenir la connexion à la base de données, l'autoload des classes,
// et d'autres paramètres nécessaires au bon fonctionnement du site
require_once "backend/initialize.php";

// Vérifie si une session utilisateur est active en regardant si 'userLoggedIn' est défini dans $_SESSION
// Cela signifie qu'un utilisateur est déjà authentifié et connecté
if (isset($_SESSION['userLoggedIn'])) {

    // Récupère l'identifiant de l'utilisateur stocké dans la session
    $user_id = $_SESSION['userLoggedIn'];

    // Utilise la classe de gestion des utilisateurs ($loadFromUser) pour récupérer les données complètes de l'utilisateur
    // La méthode `userData()` va chercher en base de données les informations associées à l'ID utilisateur
    $user = $loadFromUser->userData($user_id);
} else {
    redirect_to(url_for('index'));
}

?>
<?php $pageTitle = 'Vérification du compte | Jobber'; ?>
<?php require_once './backend/shared/header.php'; ?>

<section class="sign-container">
    <?php require_once './backend/shared/signNav.php'; ?>
    <div class="form-container">
        <div class="form-content">
            <div class="header-form-content">
                <h2>Un email de vérification vous a été envoyé à <?php echo $user->email ?>. Vérifiez votre boite mail.
                    Si vous ne le voyez pas, vérifiez les spams.</h2>
            </div>
        </div>
    </div>
</section>