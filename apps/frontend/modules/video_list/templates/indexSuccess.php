<div class="menu">
    <ul class="menu-list">
        <li class="no-left-border">
            <a href="<?php echo url_for('@videos'); ?>">Добавленые</a>
        </li>
        <li>
            <a href="<?php echo url_for('@videos'); ?>">Просмотренные</a>
        </li>
        <li>
            <a href="<?php echo url_for('@videos'); ?>">Обсуждаемые</a>
        </li>
        <li  class="no-right-border">
            <a href="<?php echo url_for('@videos'); ?>">Лучшие</a>
        </li>
    </ul>
</div>
<ul>
    <?php foreach($videos as $video): ?>
        <li style="width: 110px; float: left; padding-top: 10px; margin-left: 30px;" class="mouse_move">
            <span>
                <a href="<?php echo url_for('@view_video?video_id='.$video->getId()); ?>">
                    <div id="sl_<?php echo $video->getId(); ?>" style="width: 120px; height: 90px; display: block;" class="slider_JS">

                            <?php foreach($video->getScrinshots() as $scrinshot): ?>
                                    <?php echo image_tag('/uploads/scrinshot/'.$scrinshot->getFile(), array('width'=>'120', 'height'=>'90')); ?>
                            <?php endforeach; ?>

                    </div>
                </a>
                <?php echo $video->getTitle(); ?>
            </span>
        </li>
    <?php endforeach ?>
</ul>

<script type="text/javascript">
    jQuery(document).ready(function(){

        jQuery(".slider_JS").slidesjs({
            pagination: false,
            play : {
                active: true,
                auto: false,
                interval: 800,
                swap: true
            }
        });
        jQuery(".slidesjs-navigation").hide();

        jQuery(".slider_JS").mouseover(function(){

            jQuery(this).find(".slidesjs-play").click();

        })

        jQuery(".slider_JS").mouseout(function(){

            jQuery(this).find(".slidesjs-stop").click();

        })
   });





</script>