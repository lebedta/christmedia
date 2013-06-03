<?php

class UserProfileForm extends BasesfGuardUserProfileForm
{

    public function configure($options = array(), $messages = array())
    {
        parent::configure();

        $this->useFields(array('avatar'));

        $this->widgetSchema['avatar'] = new sfWidgetFormInputFile();

        $this->validatorSchema['avatar'] = new sfValidatorFile(array(
            'required' => false,
            'max_size' => 2097152,
            'path' => sfConfig::get('sf_web_dir').'/uploads/avatar',
            'mime_types' => 'web_images'),array('max_size' => 'File is too large (maximum is 2M).'));
        $this->widgetSchema['avatar'] = new sfWidgetFormInputFile();
    }



}