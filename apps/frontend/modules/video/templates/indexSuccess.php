<h1>Videos</h1>
<br/>
<a href="<?php echo url_for('@upload_video');?>">Upload video</a>
<a href="<?php echo url_for('@youtube_video');?>">Upload video from youtube</a>

<?php foreach($videos as $video): ?>
<li>
    <span>
        <a href="<?php echo url_for('@view_video?video_id='.$video->getId()); ?>">
            <?php echo $video->getTitle(); ?>
            <div style="width: 50px; height: 50px;">
                <?php echo image_tag('/uploads/scrinshot/'.$video->getScrinshot()->getFile(), array('width'=>'50', 'height'=>'50')); ?>
            </div>
        </a>
        <?php echo $video->getDuration(); ?>

    </span>
</li>
<?php endforeach ?>