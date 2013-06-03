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
        $this->widgetSchema['desc_file'] = new sfWidgetFormInputFile(array('label' => 'Описание'));
        $this->widgetSchema['category_id'] = new sfWidgetFormDoctrineChoice(array(
            'model' => 'Category',
            'query' => CategoryTable::getCategories(),
            'add_empty' => 'Выберите категорию'
        ));
        $this->validatorSchema['category_id'] = new sfValidatorDoctrineChoice(array('required' => true,'model'=>'Category'));

        $this->widgetSchema['date_upload'] = new sfWidgetFormDateTime();
        $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();

        $this->validatorSchema['file'] = new sfValidatorFile(array(
            'required'   => true,
            'path'       => sfConfig::get('sf_upload_dir').'/video',
            'mime_types' => array('video/mpeg','video/mpg','video/mp4','video/flv','video/x-flv','video/avi','video/x-msvideo')));

        $this->validatorSchema['desc_file'] = new sfValidatorFile(array(
            'required'   => false,
            'path'       => sfConfig::get('sf_upload_dir').'/description',
            'mime_types' => array('txt')));

        $this->widgetSchema['filming_place'] = new sfWidgetFormInput();
        $this->widgetSchema['filming_date'] = new sfWidgetFormInput();

        $this->widgetSchema->setLabel("title", "Название");
        $this->widgetSchema->setLabel("description", "Описание");
        $this->widgetSchema->setLabel("file", "Видео");
        $this->widgetSchema->setLabel("category_id", "Выберите категорию");
        $this->widgetSchema->setLabel("filming_place", "Место сьемки");
        $this->widgetSchema->setLabel("filming_date", "Дата сьемеи");

        $this->useFields(array('title', 'description', 'category_id', 'file', 'desc_file', 'filming_date', 'filming_place'));
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

        $this->getObject()->setDateUpload(date('Y-m-d H:m:s'));

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
