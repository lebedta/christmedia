<?php
/*
 * This file is part of the sfLucenePLugin package
 * (c) 2007 - 2008 Carl Vondrick <carl@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Empty class for sfLuceneSimpleForm. If you wish to extend this form, overload
 * this class.  This class will always be empty.
 *
 * This form represents the simple form that is displayed on the standard search
 * interface.
 *
 * @package    sfLucenePlugin
 * @subpackage Form
 * @author     Carl Vondrick <carl@carlsoft.net>
 * @version SVN: $Id: sfLuceneSimpleForm.class.php 7108 2008-01-20 07:44:42Z Carl.Vondrick $
 */

class sfLuceneSimpleForm extends sfLuceneSimpleFormBase
{
    public function configure()
    {
        $choices = array(
            'all' => 'Everywhere',
            'video' => 'Videos',
            'audio' => 'Audios',
            'blog' => 'Blogs'
        );
        $this->widgetSchema['entity'] = new sfWidgetFormChoice(array('choices' => $choices));
        $this->validatorSchema['entity'] = new sfValidatorChoice(array('choices' => array_keys($choices), 'required' => false));
    }
}
