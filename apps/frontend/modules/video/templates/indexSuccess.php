<h1>Videos</h1>
<br/>
<a href="<?php echo url_for('@upload_video');?>">Upload video</a>
<a href="<?php echo url_for('@youtube_video');?>">Upload video from youtube</a>

<?php foreach($videos as $video): ?>
<li>
    <a href="<?php echo url_for('@view_video?video_id='.$video->getId()); ?>"><?php echo $video->getFile(); ?></a>
</li>
<?php endforeach ?>