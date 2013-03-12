<h2>Загрузка видео</h2>
<div class="form">
    <form id="this_form"  name="<?php echo($form->getName()) ?>" method="post" action="<?php echo url_for("@upload_video") ?>" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <?php include_partial('video/form', array('form' => $form)) ?>
        <input type="submit" id="Upload" value="Upload"/>
    </form>
</div>
<div id="progress_bar" style="display:none;">
   <?php echo image_tag('ajax-loader.gif'); ?>
</div>
<div id="compleate" style="display:none;">
    <p>
        Ваше видео загружено, сразу же после серверной обработки это видео появится на странице "Видео"
    </p>
    <p>
        Загрузить еще <?php echo link_to("загрузить","@upload_video"); ?>
    </p>
</div>    
<script type="text/javascript">
    jQuery("#this_form").submit(function(event){
        var error = false;
        if(jQuery("#video_title").val() == "")
        {
            call_error_message("Назавние должно быть заполнено ",jQuery("#video_title").parent().prev());
            error = true;
        }
        if(jQuery("#video_description").val() == "")
        {
            call_error_message("Описание должно быть заполнено ",jQuery("#video_description").parent().prev());
            error = true;
        }
        if(jQuery("#video_category_id").val() == "")
        {
            call_error_message("Выберите категорию",jQuery("#video_category_id").parent().prev());
            error = true;
        }
        if(jQuery("#video_file").val() == "")
        {
            call_error_message("Загрузите видео",jQuery("#video_file").parent().prev());
            error = true;
        }

       if(error == false)
       {
           jQuery(".form").hide();
           jQuery("#progress_bar").show();


           jQuery('#this_form').ajaxSubmit(
           {
               type: "POST",
               url: "<?php echo url_for("@upload_video"); ?>",
               'success': function()
               {
                   jQuery("#progress_bar").hide();
                   jQuery("#compleate").show();
               },
               dataType:"JSON"
           });
       }
       return false;
    });
</script>