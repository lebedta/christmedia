<?php

/**
 * Youtube form.
 *
 * @package    blueprint
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class YoutubeForm extends BaseYoutubeForm
{
    public function configure()
    {
        $this->widgetSchema['title'] = new sfWidgetFormInput();
        $this->widgetSchema['description'] = new sfWidgetFormTextarea();
        $this->widgetSchema['scrinshot'] = new sfWidgetFormInputFile(array('label' => 'Скриншот'));
        $this->widgetSchema['link_youtube'] = new sfWidgetFormInput();
        $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['download'] = new sfWidgetFormInputHidden();

        $this->validatorSchema['scrinshot'] = new sfValidatorFile(array(
            'required'   => true,
            'path'       => sfConfig::get('sf_upload_dir').'/video',
            'mime_types' => 'web_images'));

        $this->useFields(array('title', 'description', 'scrinshot', 'link_youtube'));
    }
}
