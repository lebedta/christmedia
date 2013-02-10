<?php // print_r($obj); ?>
<?php if($obj): ?>
    <?php if($child == false ): ?>
        <?php $user_name = $obj['u_first_name'].' '.$obj['u_last_name'] ?>
        <?php $pr_avatar = $obj['pr_avatar']  ?>
        <?php $user_id = $obj['u_id'] ?>
        <?php $record_id = $obj['c_id'] ?>
        <?php $re = null; ?>
    <?php else: ?>
        <?php $user_name = $obj['s2_first_name'].' '.$obj['s2_last_name'] ?>
        <?php $pr_avatar = $obj['p_avatar']  ?>
        <?php $user_id = $obj['s2_id'] ?>
        <?php $record_id= $obj['c2_id']; ?>
        <?php $re = 'Re: '.$obj['c2_reply_author'] ?>
    <?php endif ?>

    <div class="avtor">
        <span class="top-sticker"></span>
        <?php if(is_null($pr_avatar) || ($pr_avatar == "")):  ?>
        <?php echo image_tag("avatar_default_100.jpg") ?>
        <?php else: ?>
            <?php $image_file_name = explode(".", $pr_avatar); ?>
        <img src="/uploads/companies/company_<?php echo $obj['pr_company_id']; ?>/<?php echo $image_file_name[0]."_100.".$image_file_name[1]; ?>">
        <?php endif ?>

        <?php echo $user_name ?>
    </div>

    <div class="re">
        <span class="author">
        <?php if($obj['c_author_website'] != ""): ?>
            <a href="<?php echo $obj['c_author_website'] ?>" target="_blank" rel="me nofollow"><?php echo $re ?></a>
            <?php else: ?>
            <?php echo $re ?>
            <?php endif; ?>
        </span>
    </div>

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

    <div class="reply-quote">
        <?php echo link_to_function(
            'Reply' ,
            "reply('".$obj['c_id']."','".$user_name."','".$user_id."', '".$form_name."')",
            array('class'=>'pop-up_form','href'=>'#comment_form','title' => __('Reply to this comment', array(), 'vjComment'))) ?>


        <?php echo link_to_function(
            'Quote' ,
            "quote('".$record_id."','".$user_name."','".$user_id."', '".$form_name."','".$obj['c_id']."')",
            array('class'=>'pop-up_form','href'=>'#comment_form','title' => __('Quoye to this comment', array(), 'vjComment'))) ?>
    </div>

<?php endif; ?>


