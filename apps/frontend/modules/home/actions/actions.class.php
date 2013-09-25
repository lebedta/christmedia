<?php

/**
 * home actions.
 *
 * @package    blueprint
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {

    }

    public function executeForgotPassword(sfRequest $request)
    {
        $this->form = new RestorePasswordForm();

        if($request->isMethod('post'))
        {
            $this->form->bind($request->getPostParameter($this->form->getName()));
            if($this->form->isValid())
            {
                $email = $this->form->getValue('email_address');
                $user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('email_address', $email);

                $last_time_nuber = strtotime($user->getCreatedAt()) % 10;
                $new_password = substr(sha1($email.time()), $last_time_nuber, 5);

                $user->changePassword($new_password);

                $message = $this->getMailer()->compose(
                    array(sfConfig::get('app_email_notification_from_email', 'blueprint@admin.com') => sfConfig::get('app_email_notification_from_name', 'Blueprint')),
                    $user->getEmailAddress(),
                    sfConfig::get('app_email_notification_title', 'Restore password'),
                    "You new password ".$new_password
                );

                try {
                    $this->getMailer()->send($message);
                    $this->getUser()->setFlash('success', 'Пароль успешно восстановлен. Новый пароль выслан на адресс '.$user->getEmailAddress());

                } catch (Exception $e) {
                    $this->getUser()->setFlash('error', 'Ошибка почтового сервера. Попробуйте восстановить пароль позже.');
                }

                $this->redirect("@sf_guard_signin");
            }
        }
    }
}
