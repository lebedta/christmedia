<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
      <?php include_http_metas() ?>
      <?php include_metas() ?>
      <?php include_title() ?>
      <link rel="shortcut icon" href="/favicon.ico" />
      <?php include_stylesheets() ?>
      <?php include_javascripts() ?>
      <script type="text/javascript" src="/js/jquery.mousewheel.min.js"></script>
      <script type="text/javascript" src="/js/jquery.em.js"></script>
      <script type="text/javascript" src="/js/jquery.jScrollPane.js"></script>
  </head>
  <body>
      <div class="global-wrapper">

          <?php include_component('home', 'loginform'); ?>
          <script type="text/javascript">
              $('.login-form').click(function(){
                  $(this).addClass('clicked');
              });
              $('.login-form').mouseleave(function(){
                  $(this).removeClass('clicked');
              });
        </script>

          <div class="content">
                  <div class="menu">
                      <div class="wrapper">
                          <ul class="menu-list">
                              <li class="no-left-border">
                                  <a href="<?php echo url_for('@videos'); ?>">Видео</a>
                              </li>
                              <li>
                                  <a href="<?php echo url_for('@videos'); ?>">Музыка</a>
                              </li>
                              <li>
                                  <a href="<?php echo url_for('@videos'); ?>">Книги</a>
                              </li>
                              <li>
                                  <a href="<?php echo url_for('@upload_video'); ?>">Загрузка</a>
                              </li>
                              <li  class="no-right-border">
                                  <a href="<?php echo url_for('@videos'); ?>">Блог</a>
                              </li>
                      </ul>
    <!--                  <form id="search" action="--><?php //echo url_for('@search?domain_name='.$sf_user->getGuardUser()->getProfile()->getCompany()->getSubDomain()) ?><!--" method="get" class="search-controls">-->
    <!--                      --><?php //$form = new sfLuceneSimpleForm(); echo $form['query']; ?>
    <!---->
    <!--                          <div class="fake-select" id="top-search">-->
    <!--                              --><?php //echo $form['entity']; ?>
    <!--                              <div class="textfield"></div>-->
    <!--                          </div>-->
    <!---->
    <!--                      <input type="submit" name="commit" accesskey="s" value="--><?php //echo __('Go') ?><!--" />-->
    <!--                  </form>-->
                  </div>
              </div>

                  <div class="wrapper">
                      <?php echo $sf_content ?>
                  </div>
          </div>
          <div class="footer">
              <div class="wrapper">
                  <p>powered by <a>ChristMedia</a></p>
              </div>
          </div>
      </div>
  </body>
</html>