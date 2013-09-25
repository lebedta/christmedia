<?php

class RestorePasswordForm extends BaseForm
{
    public function setup()
    {
        $this->setWidgets(array(
            'email_address'        => new sfWidgetFormInputText(),
//            'captcha'              => new sfWidgetCaptchaGD(),
        ));

        $this->setValidators(array(
            'email_address'         => new sfValidatorEmail(),
//            'captcha'               => new sfCaptchaGDValidator(array('length' => 4), array('invalid' => "Ошибка", "required" => "Обязательное поле")),
        ));

        $this->widgetSchema->setLabels(array(
            'email_address' => 'Ваша почта*',
//            'captcha'       => 'Защита*',
        ));

        $this->widgetSchema->setNameFormat('restore_password[%s]');

        $this->validatorSchema->setPostValidator(new UserEmailValidator(array('email_field' => 'email_address'), array('invalid' => 'Такого адреса в базе нету!!!')));

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }
}
