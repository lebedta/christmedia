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
      $this->form = new VideoForm();
      if($request->isMethod("post"))
      {
          $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

          if($this->form->isValid())
          {
              $this->form->save();
              $this->redirect("@videos");
          }
          else
          {
              $this->getUser()->setFlash('error', 'The form is invalid');
          }
      }
  }


}
