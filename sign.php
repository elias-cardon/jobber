<?php $pageTitle = 'Inscription | Jobber';0 ?>
<?php require_once './backend/shared/header.php'; ?>

<section class="sign-container">
    <nav class="nav-header-sing__up">
        <ul>
            <li>
                <a href="index.php">
                    <i class="fa fa-twitter"></i>
                    Accueil
                </a>
            </li>
            <li>
                <a href="#">A propos</a>
            </li>
            <li>
                <a href="#">Langue : Français</a>
            </li>
        </ul>
    </nav>
    <div class="form-container">
        <div class="form-content">
            <div class="header-form-content">
                <h2>Créez votre compte</h2>
            </div>
            <form action="sign.php" class="formField">
                <div class="form-group">
                    <label for="firstName">Prénom</label>
                    <input type="text" name="firstName" id="firstName">
                </div>
            </form>
        </div>
    </div>
</section>