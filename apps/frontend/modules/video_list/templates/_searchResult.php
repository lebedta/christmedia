<?php if($result->getIsScrinshot()): ?>
    <div>
        <?php echo image_tag($result->getScrinshot()); ?>
    </div>
    <div>
        <?php echo link_to($result->getTitle(), "@view_video?video_id=".$result->getId()); ?>
    </div>
    <div>
        <?php echo $result->getDescription(); ?>
    </div>

    <div>
        <?php echo $result->getCreator(); ?>
    </div>
<?php else: ?>

<?php endif; ?>