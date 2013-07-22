<?php

/**
 * video actions.
 *
 * @package    blueprint
 * @subpackage video
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class videoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */

  public function executeUploadVideo(sfWebRequest $request)
  {

      $result = array("content" => "start",
          "status" => "false");

      $this->form = new VideoForm();
      //$this->form->setUserId(sfContext::getInstance()->getUser()->getGuardUser()->getId());
      $this->form->setDefault('user_id',sfContext::getInstance()->getUser()->getGuardUser()->getId());
      if($request->isMethod("post"))
      {
          $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
          if($this->form->isValid())
          {
              $this->form->save();

              $result = array("content" => "compleate",
                               "status" => "ok");
          }
          $this->renderText(json_encode($result));
          return sfView::NONE;
      }
  }
}
