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
        <li style="width: 110px; float: left; padding-top: 10px;">
            <span>
                <a href="<?php echo url_for('@view_video?video_id='.$video->getId()); ?>">

                    <div style="width: 100px; height: 100px;">
                        <?php echo image_tag('/uploads/scrinshot/'.$video->getScrinshot()->getFile(), array('width'=>'100', 'height'=>'100')); ?>
                        <?php echo $video->getTitle(); ?>
                    </div>
                </a>
            </span>
        </li>
    <?php endforeach ?>
</ul>