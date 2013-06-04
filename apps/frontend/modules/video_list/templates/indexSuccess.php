<?php include_partial("video_list/subMenu"); ?>
<aside>
    <?php include_partial("video_list/menuTree"); ?>
</aside>
<div class="content">
    <ul class="video-prewiev">
        <?php foreach($videos->getResults() as $video): ?>
        <li style="float: left; " class="mouse_move">
            <span>
                <a href="<?php echo url_for('@view_video?video_id='.$video->getId()); ?>">
                    <div id="sl_<?php echo $video->getId(); ?>" style="" class="slider_JS">

                        <?php foreach($video->getScrinshots() as $scrinshot): ?>
                        <?php echo image_tag('/uploads/scrinshot/'.$scrinshot->getFile(), array('width'=>'200', 'height'=>'117')); ?>
                        <?php endforeach; ?>

                    </div>
                    <?php echo $video->getTitle(); ?>
                </a>

            </span>
            <div id="star_<?php echo $video->getId(); ?>" class="star"></div>
            <span>
                Просмотров: <?php echo $video->getVideoWatching()->count(); ?>
            </span>
            <script type="text/javascript">
                jQuery('#star_<?php echo $video->getId()?>').raty({
                    path: "/rating",
                    score: <?php echo $video->getVideoRating(); ?>,
                    readOnly: true
                });
            </script>
        </li>
        <?php endforeach ?>
    </ul>
</div>

<div class="pager" style="...">
    <?php include_partial('video_list/paginator', array('params' => array('type' => '', 'name' => 'page_idea') ,'pager' => $videos, 'action_link' => urlencode('@videos?order='.$order))); ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){

        jQuery(".slider_JS").slidesjs({
            pagination: false,
            play : {
                active: true,
                auto: false,
                interval: 700,
                swap: true,
                effect: {
                    slide: {
                        // Slide effect settings.
                        speed: 200
                        // [number] Speed in milliseconds of the slide animation.
                    },
                    fade: {
                        speed: 200,
                        // [number] Speed in milliseconds of the fade animation.
                        crossfade: true
                        // [boolean] Cross-fade the transition.
                    }
                }
            }
        });
        jQuery(".slidesjs-navigation").hide();

        jQuery(".slider_JS").mouseover(function(){

            jQuery(this).find(".slidesjs-play").click();
            return false;
        })

        jQuery(".slider_JS").mouseout(function(){

            jQuery(this).find(".slidesjs-stop").click();

        })
   });
</script>