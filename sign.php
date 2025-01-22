<?php

// Inclut le fichier d'initialisation qui charge les configurations, classes, et fonctions nécessaires
require_once "backend/initialize.php";

// Vérifie si la requête reçue est de type POST
if (is_post_request()) {

    // Vérifie si le champ 'firstName' est présent dans le formulaire et qu'il n'est pas vide
    if (isset($_POST['firstName']) && !empty($_POST['firstName'])) {

        // Nettoie et assainit les données saisies dans le formulaire
        // Le prénom est assaini et validé pour ne contenir que des caractères valides
        $fname = FormSanitizer::formSanitizerName($_POST['firstName']);
        // Le nom est également assaini et validé
        $lname = FormSanitizer::formSanitizerName($_POST['lastName']);
        // L'email est nettoyé pour supprimer tout caractère ou espace indésirable
        $email = FormSanitizer::formSanitizerString($_POST['email']);
        // Le mot de passe est nettoyé (sans vérification de sa sécurité à ce stade)
        $password = FormSanitizer::formSanitizerString($_POST['pass']);
        // La confirmation du mot de passe est également nettoyée
        $password2 = FormSanitizer::formSanitizerString($_POST['pass2']);

        // Génère un nom d'utilisateur unique à partir du prénom et du nom de famille
        // Cette méthode vérifie si le nom généré est déjà utilisé et, si nécessaire, ajoute un suffixe unique
        $username = $account->generateUsername($fname, $lname);

        // Tente d'enregistrer un nouveau compte utilisateur avec les données fournies
        // La méthode `register` effectue des validations (prénom, nom, email, mots de passe)
        // et insère les données dans la base si aucune erreur n'est détectée
        $wasSuccessfull = $account->register($fname, $lname, $username, $email, $password, $password2);

        // Vérifie si l'enregistrement a été effectué avec succès
        if ($wasSuccessfull) {
            // Si l'enregistrement est réussi :
            // - Renouvelle l'ID de session pour des raisons de sécurité
            session_regenerate_id();

            // Stocke l'identifiant de l'utilisateur connecté dans la session
            $_SESSION['userLoggedIn'] = $wasSuccessfull;

            // Si l'utilisateur a coché "Se souvenir de moi", enregistre cette préférence dans la session
            if (isset($_POST['remember'])) {
                $_SESSION['rememberMe'] = $_POST['remember'];
            }

            // Redirige l'utilisateur vers une page de vérification (ou autre action post-enregistrement)
            redirect_to("verification");
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
                    <input type="text" name="firstName" id="firstName" value="<?php getInputValue("firstName"); ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Nom</label>
                    <?php echo $account->getErrorMessage(Constant::$lastNameCharacters); ?>
                    <input type="text" name="lastName" id="lastName" value="<?php getInputValue("lastName"); ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <?php echo $account->getErrorMessage(Constant::$emailInUse); ?>
                    <?php echo $account->getErrorMessage(Constant::$emailInvalid); ?>
                    <input type="email" name="email" id="email" value="<?php getInputValue("email"); ?>" autocomplete="off" required>
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