<?php

/**
 * youtube actions.
 *
 * @package    blueprint
 * @subpackage youtube
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class youtubeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */

  public function executeYoutubeVideo(sfWebRequest $request)
  {
      $this->form = new YoutubeForm();
      //$this->form->setDefault('user_id', 2);
      $this->form->setDefault('download', true);
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
