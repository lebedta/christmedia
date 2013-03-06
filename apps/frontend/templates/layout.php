<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
      <?php include_http_metas() ?>
      <?php include_metas() ?>
      <?php include_title() ?>
      <link rel="shortcut icon" href="/favicon.ico" />
      <?php include_stylesheets() ?>
      <?php include_javascripts() ?>
<!--      <script type="text/javascript" src="/js/jquery.mousewheel.min.js"></script>-->
<!--      <script type="text/javascript" src="/js/jquery.em.js"></script>-->
<!--      <script type="text/javascript" src="/js/jquery.jScrollPane.js"></script>-->

  </head>
  <body>
      <div class="global-wrapper">

          <?php include_component('home', 'loginform'); ?>
          <script type="text/javascript">
              jQuery('.login-form').click(function(){
                  jQuery(this).addClass('clicked');
              });
              jQuery('.login-form').mouseleave(function(){
                  jQuery(this).removeClass('clicked');
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
                              <li>
                                  <a href="<?php echo url_for('@videos'); ?>">Блог</a>
                              </li>
                              <li class="no-right-border">
                                  <form id="search" action="<?php echo url_for('@search') ?>" method="get" class="search-controls">
                                      <?php
                                      $form = new sfLuceneSimpleForm();
                                      echo $form['query']; ?>

                                      <div class="fake-select" id="top-search">
                                          <?php echo $form['entity']; ?>
                                          <div class="textfield"></div>
                                      </div>



                                      <input type="submit" name="commit" accesskey="s" value="<?php echo __('Go') ?>" />
                                  </form>
                              </li>
                      </ul>
                  </div>
              </div>
                  <div class="wrapper">
                      <?php echo $sf_content ?>
                  </div>
          </div>
          <div class="footer">
              <div class="wrapper">
                  <p>@ Christmedia.org-Христианское видео онлайн 2011</p>
                  <p>Exclusive Hosting Partner-ValcoHosting </p>
              </div>
          </div>
      </div>
      <script type="text/javascript">
          jQuery("form#search").submit(function(){
              var inputVal = jQuery("#form_query").val();
              var characterReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
              if(!characterReg.test(inputVal)) {
                  jQuery("#form_query").val('NOT RESULT FIND');
              }
              return true;
          });

          jQuery('.search-controls input[type="text"]').val('Search...');

          jQuery('.search-controls input[type="text"]').focusin(function(){
              jQuery(this).val('');
          }).focusout(function() {
                  if ( !jQuery(this).val() ) {
                      jQuery(this).val('Search...');
                  }
              });

          //    jQuery('#top-search .textfield').width( jQuery('.fake-select select').width() );
          jQuery('#top-search .textfield').text('Everywhere');

          jQuery('.fake-select select').change(function(){
              jQuery(this).parent().find('.textfield').text( jQuery(this).find('option:selected').clone().children().remove().end().text() );
          });

          jQuery(document).ready(function() {
              jQuery('.fake-select .textfield').each(function() {
                  jQuery(this).text( jQuery(this).parent().find('select option:selected').clone().children().remove().end().text()  );
              });
          });

          /* event for errors */
          jQuery('ul.custom_error_list').find('li').bind('click', function(){
              jQuery(this).parent().hide();
          });
          jQuery(document).ready(function(){
              jQuery('<li><h2> »</h2></li>').insertAfter(jQuery('ul.path li h2 a').parent().parent());
          });

      </script>
  </body>
</html>