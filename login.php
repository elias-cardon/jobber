<?php $pageTitle='Connexion | Jobber'; ?>
<?php require_once './backend/shared/header.php';?>
<body>
<section class="sign-container">
    <?php require_once './backend/shared/signNav.php'; ?>
    <div class="form-container">
        <div class="form-content">
            <div class="header-form-content">
                <h2>Connectez-vous</h2>
            </div>
            <form action="sign.php" class="formField">
                <div class="form-group">
                    <label for="un">Pseudo ou Email</label>
                    <input type="text" name="un" id="un" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pass">Mot de passe</label>
                    <input type="password" name="pass" id="pass" autocomplete="off">
                </div>
                <div class="s-password">
                    <input type="checkbox" id="s-password" class="form-checkbox" onclick="showLoginPassword()">
                    <label for="s-password">Montrer le mot de passe</label>
                </div>
                <div class="form-btn-wrapper">
                    <button type="submit" class="btn-form" name="login">Se connecter</button>
                    <input type="checkbox" class="form-checkbox" id="check" name="remember">
                    <label for="check">Se souvenir de moi</label>
                </div>
            </form>
        </div>
        <footer class="form-footer">
            <p>Pas encore inscrit ? <a href="sign.php">S'inscrire</a></p>
        </footer>
    </div>
</section>
</body>
</html>

<script src="frontend/assets/js/showPassword.js"></script>