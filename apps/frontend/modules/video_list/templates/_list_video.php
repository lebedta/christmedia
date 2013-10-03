<?php foreach($videos as $video): ?>
    <li style="float: left; " class="mouse_move">
                <span>
                    <a href="<?php echo url_for('@view_video?video_slug='.$video->getSlug()); ?>">
                        <div id="sl_<?php echo $video->getId(); ?>" style="" class="slider_JS">

                            <?php foreach($video->getScrinshots() as $scrinshot): ?>
                                <?php echo image_tag('/uploads/scrinshot/'.$scrinshot->getFile(), array('width'=>'200', 'height'=>'117')); ?>
                            <?php endforeach; ?>

                        </div>
                        <span class="video_title"> <?php echo $video->getTitle(); ?> </span>
                    </a>

                </span>
        <div id="star_<?php echo $video->getId(); ?>" class="star" data-star="<?php echo $video->getVideoRating(); ?>"></div>
                <span>
                    Просмотров: <?php echo $video->getVideoWatching()->count(); ?>
                </span>
    </li>
<?php endforeach ?>