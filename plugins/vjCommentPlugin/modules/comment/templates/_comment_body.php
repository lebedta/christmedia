    <div class="body">
        <?php if($obj): ?>
          <?php if($child == false): ?>
            <div id="body_<?php echo $obj['c_id'] ?>"> <?php echo urldecode($obj['c_body']) ?></div>
          <?php else: ?>
            <div id="body_<?php echo $obj['c2_id'] ?>"> <?php echo urldecode($obj['c2_body']) ?></div>
          <?php endif ?>
        <?php else: ?>
        <div class="msg-deleted"><?php echo __('Comment deleted by moderator', array(), 'vjComment') ?></div>
        <?php endif ?>
    </div>
