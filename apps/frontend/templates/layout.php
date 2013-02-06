<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>

    <h1>Video hosting</h1>

    <?php if(sfContext::getInstance()->getUser()->isAuthenticated()):  ?>
        <?php echo sfContext::getInstance()->getUser()->getGuardUser()->getFullName(); ?>
        <?php echo link_to("Logout", "@sf_guard_signout"); ?>
        <?php echo link_to("Videos", "@videos"); ?>
    <?php else: ?>
        <?php echo link_to("Registration", "@registration"); ?>
    <?php endif; ?>

    <div>
        <?php echo $sf_content ?>
    </div>

  </body>
</html>