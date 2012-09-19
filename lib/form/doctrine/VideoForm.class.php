<?php

/**
 * Video form.
 *
 * @package    blueprint
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VideoForm extends BaseVideoForm
{
    public function configure()
    {
        $this->widgetSchema['title'] = new sfWidgetFormInput();
        $this->widgetSchema['description'] = new sfWidgetFormTextarea();
        $this->widgetSchema['scrinshot'] = new sfWidgetFormInputFile(array('label' => 'Скриншот'));
        $this->widgetSchema['file'] = new sfWidgetFormInputFile(array('label' => 'Видео'));
        $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();

        $this->validatorSchema['scrinshot'] = new sfValidatorFile(array(
            'required'   => false,
            'path'       => sfConfig::get('sf_upload_dir').'/video',
            'mime_types' => 'web_images'));
        $this->validatorSchema['file'] = new sfValidatorFile(array(
            'required'   => true,
            'path'       => sfConfig::get('sf_upload_dir').'/video',
            'mime_types' => array('video/mpeg','video/mpg','video/mp4','video/flv','video/avi')));

        $this->useFields(array('title', 'description', 'scrinshot', 'file'));
    }

    public function doSave($con = null)
    {
        parent::doSave($con);

        $video = $this->getValue('file');
        $video_name = substr($video, strrpos($video, '/') +1);
        $temp = explode('.', $video_name);
        if($temp[1] == 'flv')
        {
            $this->getObject()->getIsActive(true);
            $this->getObject()->setStatus('complete');
            $this->getObject()->setIsConverted(false);
            $this->getObject()->save();
        }
        else
        {
            $this->getObject()->getIsActive(false);
            $this->getObject()->setStatus('convert');
            $this->getObject()->setIsConverted(true);
            $this->getObject()->save();
        }
    }
}
