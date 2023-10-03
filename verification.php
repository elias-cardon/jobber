<?php

require_once "./backend/initialize.php";
if (isset($_SESSION["userLoggedIn"])) {
    $user_id = $_SESSION['userLoggedIn'];
    $user = $loadFromUser->userData($user_id);
}

?>
<?php $pageTitle = 'Vérification du compte | Jobber'; ?>
<?php require_once './backend/shared/header.php'; ?>
<body>
<section class="sign-container">
    <?php require_once './backend/shared/signNav.php'; ?>
    <div class="form-container">
        <div class="form-content">
            <div class="header-form-content">
                <h2>Un email de vérification vous a été envoyé (<?php echo $user->email; ?>). Veuillez vérifier votre boîte mail.</h2>
            </div>
        </div>
    </div>
</section>
</body>
</html>

<script src="frontend/assets/js/showPassword.js"></script>