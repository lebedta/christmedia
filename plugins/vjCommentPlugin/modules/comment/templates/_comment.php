<tbody class="comment<?php // if($obj->is_delete) echo " deleted"; ?>">
<tr<?php if($first_line) echo ' class="first_line"' ?>>
    <td>
    <?php if($child == false ): ?>
      <?php $created_at = $obj['c_created_at'] ?>
      <?php $user_name = null;//$obj['u_first_name'].' '.$obj['u_last_name'] ?>
    <?php else: ?>
      <?php $created_at = $obj['c2_created_at'] ?>
      <?php $user_name = 'Re: '.$obj['c2_reply_author'] ?>
    <?php endif ?>
    <?php include_partial("comment/comment_infos", array('obj' => $obj, 'i' => $i, 'form_name' => $form_name, 'child' => $child)) ?>
    <?php // include_partial("comment/comment_author", array('website' => $obj['c_author_website'], 'name' => $user_name, 'date' => $created_at)) ?>
     <?php // include_partial("comment/comment_body", array('obj' => $obj, 'child' => $child)) ?>
    </td>
</tr>
</tbody>