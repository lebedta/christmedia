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
  public function executeIndex(sfWebRequest $request)
  {
      $this->videos = VideoTable::getVideos();
  }

    public function executeViewVideo(sfWebRequest $request)
    {
        $video_id = $request->getUrlParameter('video_id');
        $this->video = Doctrine_Core::getTable('Video')->find($video_id);
        $this->forward404Unless($this->video, "Idea not exist");
    }

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
