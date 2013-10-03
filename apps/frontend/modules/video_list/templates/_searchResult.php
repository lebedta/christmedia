<?php if($result->getIsScrinshot()): ?>
    <div class="search_result_img">
        <?php echo image_tag($result->getScrinshot()); ?>
    </div>
    <div class="search_result_title">
        <?php echo link_to($result->getTitle(), "@view_video?video_slug=".$result->getSlug()); ?>
    </div>
    <div class="search_result_description">
        <?php echo $result->getDescription(); ?>
    </div>
    <div class="search_result_creator">
        <?php echo $result->getCreator(); ?>
    </div>
<?php else: ?>

<?php endif; ?>