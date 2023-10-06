<?php

require_once "./backend/initialize.php";
if (isset($_SESSION["userLoggedIn"])) {
    $user_id = $_SESSION['userLoggedIn'];
    $user = $loadFromUser->userData($user_id);
    $link = $verify->generateLink();
    $message = "{$user->firstName}, Votre compte a été créé, veuillez vérifier ce lien pour vérifier votre email <a href='http://localhost/tweety/verification/$link'>Verification</a>";
    $subject = "[Jobber] Veuillez vérifier votre compte.";
    $subject = htmlspecialchars($subject, ENT_QUOTES, "UTF-8");
    $verify->sendToMail($user->email, $message, $subject);
    $loadFromUser->create("verification",['user_id'=>$user_id,"code"=>$link]);
} else {
    redirect_to((url_for("index")));
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
                <h2>Un email de vérification vous a été envoyé (<?php echo $user->email; ?>). Veuillez vérifier votre
                    boîte mail.</h2>
            </div>
        </div>
    </div>
</section>
</body>
</html>

<script src="frontend/assets/js/showPassword.js"></script>