<?php

// Inclut le fichier d'initialisation qui charge les configurations, classes, et fonctions nécessaires
require_once "backend/initialize.php";

// Vérifie si la requête reçue est de type POST
if (is_post_request()) {
    // Vérifie si le champ 'firstName' est présent et non vide
    if (isset($_POST['firstName']) && !empty($_POST['firstName'])) {
        // Nettoie et assainit les données du formulaire
        $fname = FormSanitizer::formSanitizerName($_POST['firstName']);  // Prénom, après nettoyage et validation
        $lname = FormSanitizer::formSanitizerName($_POST['lastName']);   // Nom, après nettoyage et validation
        $email = FormSanitizer::formSanitizerString($_POST['email']);    // Email, après nettoyage et validation
        $password = FormSanitizer::formSanitizerString($_POST['pass']);  // Mot de passe, après nettoyage
        $password2 = FormSanitizer::formSanitizerString($_POST['pass2']); // Confirmation du mot de passe, après nettoyage

        // Génère un nom d'utilisateur unique à partir du prénom et du nom
        $username = $account->generateUsername($fname, $lname);

        // Appelle la méthode pour enregistrer un nouveau compte utilisateur avec les données fournies
        $wasSuccessfull = $account->register($fname, $lname, $username, $email, $password, $password2);

        // Vérifie si l'enregistrement s'est bien déroulé
        if ($wasSuccessfull) {
            // Traite le succès (par exemple, redirige l'utilisateur ou affiche un message de confirmation)
            // TODO : Ajouter ici le traitement post-enregistrement, si nécessaire
        }
    }
}



?>
<?php $pageTitle = 'Inscription | Jobber'; ?>
<?php require_once './backend/shared/header.php'; ?>

<section class="sign-container">
    <?php require_once './backend/shared/signNav.php'; ?>
    <div class="form-container">
        <div class="form-content">
            <div class="header-form-content">
                <h2>Créez votre compte</h2>
            </div>
            <form action="sign.php" class="formField" method="POST">
                <div class="form-group">
                    <label for="firstName">Prénom</label>
                    <?php echo $account->getErrorMessage(Constant::$firstNameCharacters); ?>
                    <input type="text" name="firstName" id="firstName" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Nom</label>
                    <?php echo $account->getErrorMessage(Constant::$lastNameCharacters); ?>
                    <input type="text" name="lastName" id="lastName" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <?php echo $account->getErrorMessage(Constant::$emailInUse); ?>
                    <?php echo $account->getErrorMessage(Constant::$emailInvalid); ?>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="pass">Mot de passe</label>
                    <?php echo $account->getErrorMessage(Constant::$passwordLength); ?>
                    <?php echo $account->getErrorMessage(Constant::$passwordDoNotMatch); ?>
                    <?php echo $account->getErrorMessage(Constant::$passwordDoNotAlphanumeric); ?>
                    <input type="password" name="pass" id="pass" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="cpass">Confirmer mot de passe</label>
                    <input type="password" name="pass2" id="cpass" autocomplete="off" required>
                </div>
                <div class="s-password">
                    <input type="checkbox" class="form-checkbox" id="s-password" onclick="showPassword()">
                    <label for="s-password">Montrer le mot de passe</label>
                </div>
                <div class="form-btn-wrapper">
                    <button type="submit" class="btn-form">S'inscrire</button>
                    <input type="checkbox" class="form-checkbox" id="check" name="remember">
                    <label for="check">Se souvenir de moi</label>
                </div>
            </form>
        </div>
        <footer class="form-footer">
            <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
        </footer>
    </div>
</section>
<script src="frontend/assets/js/showPassword.js"></script>