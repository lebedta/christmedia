<table summary="">
<?php foreach($form as $id => $f): ?>
  <?php if($id == "reply_author" && $f->getValue()!= ""): ?>
    <?php use_stylesheet("/vjCommentPlugin/css/replyTo.min.css", "last") ?>
  <?php endif ?>
  <?php if(!$f->isHidden()): ?>
    <?php if(!$f->hasError()): ?>
      <?php $attributes = array() ?>
    <?php else: ?>
      <?php $attributes = array('class' => 'error') ?>
      <tr>
        <td></td>
        <td><?php echo $f->renderError() ?></td>
      </tr>
    <?php endif ?>
    <tr id="tr_<?php echo $id."_".$form->getName() ?>" class="tr_<?php echo $id ?>">
      <td>
        <?php echo $f->renderLabel(null, $attributes) ?>
        <?php echo $f->render($attributes) ?>
        <span class="help"><?php echo $f->renderHelp() ?></span>
      </td>
    </tr>
    <?php if($id == "reply_author"): ?>
    <tr id="tr_reply_author_delete_<?php echo $form->getName() ?>" class="tr_reply_author_delete">
      <td colspan="2"><?php echo link_to_function(__("Delete the reply", array(), 'vjComment'), "deleteReply('".$form->getName()."')", array('class' => 'delete_reply'))."\n" ?></td>
    </tr>
    <?php endif ?>
  <?php endif ?>
<?php endforeach ?>
    <tr>
      <td colspan="2" class="submit">
          <ul class="comment-error custom_error_list special-list-position" style="display: none; top: 70px !important;">
              <li><em></em>Required.</li>
          </ul>
<?php echo $form->renderHiddenFields() ?>
        <input type="submit" value="<?php echo __('Send', array(), 'vjComment') ?>" class="btn btn-tall btn-dark-grey" />
      </td>
    </tr>
  </table>

<script type="text/javascript">
    jQuery(".submit").click(function(){
        var value =jQuery(".comment_textarea").val();
        value = value.replace(/ /g, '');
        if(value.length > 0)
        {
            jQuery(".comment-error").hide();
            return true;
        }
        else
        {
            jQuery(".comment-error").show();
            return false;
        }
    });

</script>