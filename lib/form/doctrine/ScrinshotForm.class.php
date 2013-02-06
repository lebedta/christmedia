<?php

/**
 * Scrinshot form.
 *
 * @package    blueprint
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ScrinshotForm extends BaseScrinshotForm
{
  public function configure()
  {
      $this->widgetSchema['file'] = new sfWidgetFormInput();
      $this->widgetSchema['video_id'] = new sfWidgetFormInputHidden();

      $this->useFields(array('file', 'video_id'));
  }
}
