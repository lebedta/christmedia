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
        $this->widgetSchema['file'] = new sfWidgetFormInputFile(array('label' => 'Видео'));
        $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();

        $this->validatorSchema['file'] = new sfValidatorFile(array(
            'required'   => true,
            'path'       => sfConfig::get('sf_upload_dir').'/video',
            'mime_types' => array('video/mpeg','video/mpg','video/mp4','video/flv','video/x-flv','video/avi','video/x-msvideo')));

        $this->useFields(array('title', 'description', 'file'));
    }

    public function doSave($con = null)
    {
        parent::doSave($con);
        $video = $this->getValue('file');
        $video_name = substr($video, strrpos($video, '/') +1);
        $temp = explode('.', $video_name);

        //get duration uploaded video
        $cmd = "ffmpeg -i " . $video . " 2>&1";
        exec($cmd);
        if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
            $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
        }

        if($temp[1] == 'flv')
        {
            $this->getObject()->setIsActive(true);
            $this->getObject()->setStatus('complete');
            $this->getObject()->setIsConverted(false);
            $this->getObject()->setDuration($total);
            $this->getObject()->save();
        }
        else
        {
            $this->getObject()->getIsActive(false);
            $this->getObject()->setStatus('convert');
            $this->getObject()->setIsConverted(true);
            $this->getObject()->setDuration($total);
            $this->getObject()->save();
        }
    }


}
