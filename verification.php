<?php

// Inclut le fichier d'initialisation qui charge les configurations, classes, et fonctions nécessaires
require_once "backend/initialize.php";
?>
<?php $pageTitle = 'Vérification du compte | Jobber'; ?>
<?php require_once './backend/shared/header.php'; ?>

<section class="sign-container">
    <?php require_once './backend/shared/signNav.php'; ?>
    <div class="form-container">
        <div class="form-content">
            <div class="header-form-content">
                <h2>Un email de vérification vous a été envoyé. Vérifiez votre boite mail.</h2>
            </div>
        </div>
    </div>
</section>
<script src="frontend/assets/js/showPassword.js"></script>