<h2><?php echo $video->getTitle(); ?> </h2>


<div id="page">

    <a href="<?php echo '/uploads/video/'.$video->getFile() ?>"
       style="display:block;width:500px;height:400px" id="player"></a>

    <script type="text/javascript" src="/flowplayer/flowplayer.js"></script>

</div>

<h4><?php echo $video->getDescription(); ?> </h4>

<?php //include_component('comment', 'formComment', array('object' => $video)) ?>
<?php include_component('comment', 'list', array('object' => $video, 'i' => 0)) ?>


<a class="btn btn-light-grey pop-up_form new_comment_form" href="#comment_form">Новый комент</a>
<div style="display: none;">
    <div id="comment_form" >
        <?php include_component('comment', 'formComment', array('object' => $video)) ?>
    </div>
</div>

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
</script>