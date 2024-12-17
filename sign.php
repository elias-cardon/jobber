<?php $pageTitle = 'Inscription | Jobber';
0 ?>
<?php require_once './backend/shared/header.php'; ?>

<section class="sign-container">
    <?php require_once './backend/shared/signNav.php'; ?>
    <div class="form-container">
        <div class="form-content">
            <div class="header-form-content">
                <h2>Créez votre compte</h2>
            </div>
            <form action="sign.php" class="formField">
                <div class="form-group">
                    <label for="firstName">Prénom</label>
                    <input type="text" name="firstName" id="firstName" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="lastName">Nom</label>
                    <input type="text" name="lastName" id="lastName" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pass">Mot de passe</label>
                    <input type="password" name="pass" id="pass" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="cpass">Confirmer mot de passe</label>
                    <input type="password" name="pass2" id="cpass" autocomplete="off">
                </div>
                <div class="s-password">
                    <input type="checkbox" class="form-checkbox" id="s-password">
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