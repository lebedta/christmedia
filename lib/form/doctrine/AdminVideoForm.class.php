<?php

/**
 * Video form.
 *
 * @package    blueprint
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AdminVideoForm extends BaseVideoForm
{
    public function configure()
    {
        unset($this["file"], $this['created_at'], $this['updated_at'], $this['is_scrinshot'], $this['status']);
    }
}
