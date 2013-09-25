<?php echo($form->renderHiddenFields()) ?>
<?php echo($form->renderGlobalErrors()) ?>

<ul class="text">
    <?php include_partial('home/field', array('field' => $form['email_address'])); ?>
</ul>
