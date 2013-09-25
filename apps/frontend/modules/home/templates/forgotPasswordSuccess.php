<div class="wrap blog-page">
    <?php include_partial('home/notice', array()) ?>
    <?php include_partial('home/error', array()) ?>

    <span class="login-logo"></span>
    <h1>Восстановить пароль</h1>

    <p class="password-pages-hint">Письмо с новым паролем будет выслано вам на указанный электронный адресс.</p>

    <form  name="<?php echo($form->getName()) ?>" method="post" action="<?php echo url_for("@forgot_password") ?>">
        <fieldset class="blog-login">
            <?php include_partial('home/forgot_pass_form', array('form' => $form)) ?>
            <button class="btn-grey">Восстановить</button>
        </fieldset>
    </form>
</div>