<h2><?php echo $video->getTitle(); ?> </h2>
<h4><?php echo $video->getDescription(); ?> </h4>

<div id="page">

    <a href="<?php echo '/uploads/video/'.$video->getFile() ?>"
       style="display:block;width:500px;height:400px" id="player"></a>

    <script type="text/javascript" src="/flowplayer/flowplayer.js"></script>

</div>