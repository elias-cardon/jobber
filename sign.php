<?php

require_once "./backend/initialize.php";

if (is_post_request()) {
    if (isset($_POST['firstName']) && !empty($_POST['firstName'])) {
        $fname=FormSanitizer::formSanitizerName($_POST['firstName']);
        $lname=FormSanitizer::formSanitizerString($_POST['lastName']);
        $email=FormSanitizer::formSanitizerString($_POST['email']);
        $password=FormSanitizer::formSanitizerString($_POST['pass']);
        $password2=FormSanitizer::formSanitizerString($_POST['pass2']);

        $username = $account->generateUsername($fname,$lname);

        $wasSuccessful = $account->register($fname,$lname,$username,$email,$password,$password2);
        if ($wasSuccessful){
            //process it
            $wasSuccessful;
        }
    }
}
?>
<?php $pageTitle = 'Inscription | Jobber'; ?>
<?php require_once './backend/shared/header.php'; ?>
<body>
<section class="sign-container">
    <?php require_once './backend/shared/signNav.php'; ?>
    <div class="form-container">
        <div class="form-content">
            <div class="header-form-content">
                <h2>Créer votre compte</h2>
            </div>
            <form action="sign.php" class="formField" method="POST">
                <div class="form-group">
                    <label for="firstName">Prénom</label>
                    <input type="text" name="firstName" id="firstName" value="<?php getInputValue("firstName"); ?>" autocomplete="off" required>
                    <?php
                    echo $account->getErrorMessage(Constant::$firstNameCharacters);
                    ?>
                </div>
                <div class="form-group">
                    <label for="lastName">Nom</label>
                    <input type="text" name="lastName" id="lastName" value="<?php getInputValue("lastName"); ?>" autocomplete="off" required>
                    <?php
                    echo $account->getErrorMessage(Constant::$lastNameCharacters);
                    ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php getInputValue("email"); ?>" autocomplete="off" required>
                    <?php
                    echo $account->getErrorMessage(Constant::$emailInvalid);
                    echo $account->getErrorMessage(Constant::$emailInUse);
                    ?>
                </div>
                <div class="form-group">
                    <label for="pass">Mot de passe</label>
                    <input type="password" name="pass" id="pass" autocomplete="off" required>
                    <?php
                    echo $account->getErrorMessage(Constant::$passwordLength);
                    echo $account->getErrorMessage(Constant::$passwordNotAlphanumeric);
                    ?>
                </div>
                <div class="form-group">
                    <label for="cpass">Confirmez le mot de passe</label>
                    <input type="password" name="pass2" id="cpass" autocomplete="off" required>
                    <?php
                        echo $account->getErrorMessage(Constant::$passwordDoNotMatch);
                    ?>
                </div>
                <div class="s-password">
                    <input type="checkbox" id="s-password" class="form-checkbox" onclick="showPassword()">
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
</body>
</html>

<script src="frontend/assets/js/showPassword.js"></script>