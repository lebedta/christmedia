<fieldset>

    <?php echo($form->renderHiddenFields()) ?>
    <?php echo($form->renderGlobalErrors()) ?>

    <dl>
        <?php  include_partial('video/field', array('field' => $form['title'])) ?>
        <?php  include_partial('video/field', array('field' => $form['description'])) ?>
        <?php  include_partial('video/field', array('field' => $form['category_id'])) ?>
        <?php  include_partial('video/field', array('field' => $form['file'])) ?>
        <?php  include_partial('video/field', array('field' => $form['desc_file'])) ?>
    </dl>

</fieldset>