<?php if($has_comments): ?>
<?php use_helper('Date', 'JavascriptBase', 'I18N') ?>
<?php use_stylesheet("/vjCommentPlugin/css/comment.min.css") ?>
<?php use_stylesheet("/vjCommentPlugin/css/pagination.min.css") ?>
<?php use_javascript("/vjCommentPlugin/js/reply.min.js") ?>
<?php if(commentTools::isGravatarAvailable()): ?>
    <?php use_helper('Gravatar') ?>
    <?php endif ?>
<!--
<div>
    <h1><?php echo __('Comments list', array(), 'vjComment') ?> (<?php echo $count_comments->count(); ?>)</h1>
</div>
-->
<?php if ($pager->haveToPaginate()): ?>
    <?php include_partial('comment/pagination', array('pager' => $pager, 'route' => $sf_request->getUri(), 'crypt' => $crypt, 'position' => 'top')) ?>
    <?php endif ?>
<?php $last_id = 0 ?>
<?php foreach($pager->getResults() as $c): ?>

    <?php if($c['c_id'] <> $last_id): ?>
      <?php $child = false ?>
      <table class="list-comments" summary="">
        <?php include_partial("comment/comment", array('obj' => $c, 'child' => $child, 'i' => (++$i + $cpt), 'first_line' => ($i == 1), 'form_name' => $form_name)) ?>
      </table>
    <?php endif ?>

    <?php if(isset($c['c2_id'])): ?>
      <?php $child = true ?>
      <ul>
        <table class="list-comments" summary="">
          <?php include_partial("comment/comment", array('obj' => $c, 'child' => $child, 'i' => (++$i + $cpt), 'first_line' => ($i == 1), 'form_name' => $form_name)) ?>
        </table>
      </ul>
    <?php endif ?>

    <?php $last_id = $c['c_id'] ?>

<?php endforeach; ?>

<?php if ($pager->haveToPaginate()): ?>
    <?php include_partial('comment/pagination', array('pager' => $pager, 'route' => $sf_request->getUri(), 'crypt' => $crypt, 'position' => 'back')) ?>
    <?php else: ?>
    <?php // include_partial('comment/back_to_top', array('route' => $sf_request->getUri(), 'crypt' => $crypt, 'text' => true)) ?>
    <?php endif ?>
<?php else: ?>

<?php endif ?>