<?php

/**
 * CategoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CategoryTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CategoryTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Category');
    }

    public static function getCategories()
    {
        return Doctrine_Query::create()
            ->select('*')
            ->from('Category');
    }

    public static function getParentCategories()
    {
        return Doctrine_Query::create()
            ->select('*')
            ->from('Category')
            ->where("parent_id is null")
            ->execute();
    }

    public static function getChildrenCategories($parent)
    {
        return Doctrine_Query::create()
            ->select('*')
            ->from('Category')
            ->where("parent_id = ?", $parent)
            ->execute();
    }

    public static function buildTree($parent = 0)
    {
        $arr = null;
        if($parent != 0)
        {
            $childs = self::getChildrenCategories($parent);
        }
        else
        {
            $childs = self::getParentCategories();
        }

        if($childs->count() > 0)
        {
            $arr = "<ul>";

            foreach($childs as $child)
            {
                $url = "<a href=".url_for("@videos?order=d&category=".$child->getTitle()).">".$child->getTitle()."</a>";
                $arr .= "<li><span>".$url."</span>";
                $arr .= self::buildTree($child->getId());
                $arr .= "</li>";
            }
            $arr .= "</ul>";
        }

        return $arr;
    }

    public static function getChildrenCategory($parent = 0)
    {
        $arr_id = null;
        $result = null;

        $childs = self::getChildrenCategories($parent);

        if($childs->count() >0 )
        {
            foreach($childs as $child)
            {
                $arr_id .= $child->getId().", ";
                $arr_id .= self::getChildrenCategory($child->getId());
            }
            $result = trim($arr_id, ', ');
        }

        return $result;
    }
}