<?php use_helper('I18N') ?>

<header>
    <div class="wrapper">
        <div class="logo">
        </div>
        <div class="registration">
        <?php if(!$user->isAuthenticated()): ?>

                <a href="<?php echo url_for('@sf_guard_signin') ?>" class="login-button"></a>
                <a href="<?php echo url_for("@registration") ?>" class="registration-button"></a>

        <?php else: ?>
<!--            <h1 class="logo"><a href="--><?php //echo url_for('@dashboard?domain_name='.sfContext::getInstance()->getUser()->getProfile()->getCompany()->getSubDomain()) ?><!--">--><?php //echo sfContext::getInstance()->getUser()->getProfile()->getCompany()->getName(); ?><!--</a></h1>-->
            <div class="login-form">
                <img src="<?php echo $user->getGuardUser()->getProfile()->getUserAvatar(32) ?>" alt="<?php echo $user->getGuardUser()->getFullName(); ?>" />
                <span class="user-name">
                    <?php echo $user->getGuardUser()->getFullName(); ?>
                </span>
                <!--<a href="--><?php //echo url_for('@profile') ?><!--">profile</a>-->
                <!--<a href="--><?php //echo url_for('@user_info?domain_name='.sfContext::getInstance()->getUser()->getProfile()->getCompany()->getSubDomain().'&id='.sfContext::getInstance()->getUser()->getGuardUser()->getId()); ?><!--">profile</a>-->
                <a href="<?php echo url_for('@sf_guard_signout') ?>">logout</a>
                <a href="<?php echo url_for('@profile') ?>">profile</a>
            </div>
        <?php endif;?>
        </div>
    </div>
</header>