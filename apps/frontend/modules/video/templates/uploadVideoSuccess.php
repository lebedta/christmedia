<h2>Upload video</h2>

<form  name="<?php echo($form->getName()) ?>" method="post" action="<?php echo url_for("@upload_video") ?>" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php include_partial('video/form', array('form' => $form)) ?>
    <input type="submit" value="Upload"/>
</form>