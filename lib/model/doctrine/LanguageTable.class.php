<?php

/**
 * LanguageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LanguageTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object LanguageTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Language');
    }

    public static function getLanguagesArray()
    {
        $languages_list = self::getInstance()->findBy("is_active", true);

        $LANG = array();
        foreach($languages_list as $language){
            $LANG[] = $language->getName();
        }

        return $LANG;
    }

}