<?php use_helper('I18N', 'JavascriptBase') ?>
<?php use_stylesheet("/vjCommentPlugin/css/form.min.css") ?>
<?php use_stylesheet("/vjCommentPlugin/css/formComment.min.css") ?>
<a name="comments-<?php echo $crypt ?>"></a>
<div class="form-comment">
<?php if( vjComment::checkAccessToForm($sf_user) ): ?>
  <form action="<?php echo url_for($sf_request->getUri()) ?>" method="post" name="<?php echo $form->getName() ?>">
  <fieldset>
    <legend id="title-pop-comment"><?php echo __('Add new comment', array(), 'vjComment') ?></legend>
    <?php include_partial("comment/form", array('form' => $form)) ?>
  </fieldset>
  </form>
<?php else: ?>
  <div id="notlogged"><?php echo __('Please log in to comment', array(), 'vjComment') ?></div>
<?php endif ?>
</div>

<script type="text/javascript">
    jQuery('ul.comment-error.custom_error_list.special-list-position li').click(function() {
        jQuery(this).parent().remove();
    });
</script>