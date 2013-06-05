<!DOCTYPE html>
<html lang="ru">
  <head>
      <meta charset="utf-8">
      <?php include_http_metas() ?>
      <?php include_metas() ?>
      <?php include_title() ?>
      <link rel="shortcut icon" href="/favicon.ico" />
      <?php include_stylesheets() ?>
      <?php include_javascripts() ?>
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

                <nav>
                      <div class="wrapper">
                          <ul>
                              <li id="video">
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
                      </ul>
                      <div class="search-form">
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
                      </div>
                  </div>
              </nav>
          <div class="center-background">
              <div class="wrapper">


                    <?php echo $sf_content ?>

              </div>
          </div>
          <footer>
              <div class="wrapper">
                  <div class="footer_video">
                      <img src="images/bottom_video.jpg" width="181" height="85" alt="bottom_video">
                      <img src="images/bottom_video.jpg" width="181" height="85" alt="bottom_video">
                      <img src="images/bottom_video.jpg" width="181" height="85" alt="bottom_video">
                      <img src="images/bottom_video.jpg" width="181" height="85" alt="bottom_video">
                  </div>
                  <p>@ Christmedia.org-Христианское видео онлайн 2011</p>
                  <p>Exclusive Hosting Partner-ValcoHosting </p>
              </div>
          </footer>
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