<?php include_partial("video_list/subMenu"); ?>
<aside>
    <?php include_partial("video_list/menuTree"); ?>
</aside>
<div class="content">
    <h2><?php echo $video->getTitle(); ?> </h2>

    <div id="page">

       <?php
        $video_name = substr($video->getFile(), strrpos($video->getFile(), '/'));
        $temp = explode('.', $video_name);
        ?>

        <div class="flowplayer" data-swf="/html5_flowplayer/flowplayer.swf" data-key="$289122895653393" data-ratio="0.417">
            <video>
                <source type="video/webm" src="<?php echo '/uploads/video/'.$temp[0].'.webm' ?>"/>
                <source type="video/mp4"  src="<?php echo '/uploads/video/'.$temp[0].'.mp4' ?>"/>
                <source type="video/ogv"  src="<?php echo '/uploads/video/'.$temp[0].'.ogv' ?>"/>
            </video>
        </div>

    </div>

    <h4><?php echo $video->getDescription(); ?> </h4>
    <div id="star_<?php echo $video->getId(); ?>" class="star"></div>

    <span class="view" >
        Просмотров: <?php echo $video->getVideoWatching()->count(); ?>
    </span>

    <div class="comment">
        <?php include_component('comment', 'list', array('object' => $video, 'i' => 0)) ?>
        <?php if (sfContext::getInstance()->getUser()->isAuthenticated()): ?>
            <a class="btn btn-light-grey pop-up_form new_comment_form" href="#comment_form">Новый комент</a>
            <div style="display: none;">
                <div id="comment_form" >
                    <?php include_component('comment', 'formComment', array('object' => $video)) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php if (!sfContext::getInstance()->getUser()->isAuthenticated()): ?>
    <script type="text/javascript">
        jQuery(".reply-quote").hide();
    </script>
<?php endif; ?>

<script type="text/javascript ">
    jQuery(".pop-up_form").fancybox();
    jQuery(".new_comment_form").click(function(){

        var form_name=jQuery(".form-comment").children("form").attr("name");

        jQuery('#title-pop-comment').html('Add new comment');
        document.getElementById(form_name+"_body").value = '';
        document.getElementById(form_name+"_reply").value='';
        document.getElementById(form_name+"_reply_author").value='';
        document.getElementById(form_name+"_reply_author_id").value=null;
        document.getElementById("tr_reply_author_"+form_name).style.display="table-row";
        document.getElementById("tr_reply_author_delete_"+form_name).style.display="table-row";
        document.location.href=document.location.toString().split("#")[0]+"#top";
    });

    jQuery('#star_<?php echo $video->getId(); ?>').raty({
        path: "/rating",
        score: <?php echo $video->getVideoRating(); ?>,
        readOnly: <?php echo $video->isVoting(); ?>,
        click: function(score, evt)
            {
                send_rating(score, jQuery(this).attr('id'));
            }
    });

    function send_rating(score, id)
    {
        jQuery.ajax({
            type:"POST",
            url:'<?php echo url_for("@vote_video?video_id=" .$video->getId()); ?>',
            data:{rat:score},
            success:function (data)
            {
                if (data.status == "Ok")
                {
                    var rating = data.content;
                    jQuery("#"+id).raty({
                        path: "/rating",
                        score: rating,
                        readOnly: true
                    })
                }
            },
            dataType:"JSON"
        });
    }
</script>
