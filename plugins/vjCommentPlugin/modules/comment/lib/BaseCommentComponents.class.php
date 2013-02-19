<?php

/**
 * BaseComment components.
 *
 * @package    vjCommentPlugin
 * @subpackage comment
 * @author     Jean-Philippe MORVAN <jp.morvan@ville-villejuif.fr>
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BaseCommentComponents extends sfComponents
{
  public function executeFormComment(sfWebRequest $request)
  {
    $this->form = new CommentForm(null, array('user' => $this->getUser(), 'name' => $this->generateCryptModel()));
    $this->form->setDefault('record_model', $this->object->getTable()->getComponentName());
    $this->form->setDefault('record_id', $this->object->get('id'));
    if($request->isMethod('post'))
    {
      //preparing temporary array with sent values
      $formValues = $request->getParameter($this->form->getName());
      if(vjComment::isPostedForm($formValues, $this->form))
      {
        if( vjComment::isCaptchaEnabled() && !vjComment::isUserBoundAndAuthenticated($this->getUser()) )
        {
          $captcha = array(
            'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
            'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
          );
          //Adding captcha
          $formValues = array_merge( $formValues, array('captcha' => $captcha)  );
        }
        if( vjComment::isUserBoundAndAuthenticated($this->getUser()) )
        {
          //adding user id
          $formValues = array_merge( $formValues, array('user_id' => $this->getUser()->getGuardUser()->getId())  );
        }
        $formValues = array_merge($formValues, array('body'=> nl2br(htmlspecialchars($formValues['body']))));
        $this->form->bind( $formValues );
        if ($this->form->isValid())
        {
          $this->form->save();



          $this->initPager($request);
          $url = $this->generateNewUrl($request->getUri());
          $this->getContext()->getController()->redirect($url, 0, 302);
        }
      }
    }
  }


  public function executeList(sfWebRequest $request)
  {
    $this->initPager($request);
    $this->form_name = $this->generateCryptModel();
  }

  private function initPager(sfWebRequest $request)
  {
    if ($this->has_comments = $this->object->hasComments())
    {
        $this->count_comments = $this->object->getAllComments(vjComment::getListOrder())->execute();
        $query = $this->object->getAllComments(vjComment::getListOrder())
            ->leftJoin('c.Comment c2 on c.id=c2.reply')
            ->leftJoin('c.User us')
            ->leftJoin('u.Profile pr')
            ->leftJoin('c2.User s2 on c2.user_id=s2.id')
            ->leftJoin('s2.Profile p')
            ->addwhere('c.reply is null');

        $max_per_page = count($query->execute(array() , Doctrine_Core::HYDRATE_SCALAR));
        $page = $request->getParameter('page-'.$this->generateCryptModel(), 1);

        $this->pager = new sfDoctrinePager('Comment', $max_per_page);
        $this->pager->setQuery($query);
        $this->pager->setPage($page);
        $this->pager->init();
        $this->max_per_page= $max_per_page;
        $this->cpt = $max_per_page * ($page - 1);
    }
  }

  private function generateNewUrl($uri)
  {
    $page = $this->pager->getLastPage();
    if(vjComment::getListOrder() == "DESC")
    {
      $page = $this->pager->getFirstPage();
    }
    $url = commentTools::rewriteUrlForPage($uri, $page, $this->generateCryptModel(), false);
    return  $url . "#" . $this->pager->getNbResults();
  }

  public function generateCryptModel()
  {
    $model = $this->object->getTable()->getComponentName();
    $id = $this->object->get('id');
    $this->crypt = vjComment::getFormName($model.$id);
    return $this->crypt;
  }
}
