<?php
/**
 * @package sfLucenePlugin
 * @subpackage Module
 * @author Carl Vondrick <carl@carlsoft.net>
 * @version SVN: $Id: _pagerNavigation.php 7108 2008-01-20 07:44:42Z Carl.Vondrick $
 */
?>

<?php if ($pager->haveToPaginate()): ?>
    <div class="pagination">
        <a href="<?php echo url_for('@search?'.$form->getQueryString($pager->getPreviousPage())) ?>" <?php if($pager->getPage() == $pager->getFirstPage()):?>class="unactive"<?php endif; ?>>
            <span><< Back</span>
        </a>

        <?php foreach ($pager->getLinks($radius) as $page): ?>
        <?php if ($page == $pager->getPage()): ?>
            <span><?php echo $page ?></span>
        <?php else: ?>
            <a href="<?php echo url_for('@search?'.$form->getQueryString($page)) ?>">
                <span><?php echo $page ?></span>
            </a>
            <?php endif ?>
        <?php endforeach ?>

        <a href="<?php echo url_for('@search?'.$form->getQueryString($pager->getNextPage())) ?>" <?php if($pager->getPage() == $pager->getLastPage()):?>class="unactive"<?php endif; ?>>
            <span>Next >></span>
        </a>

        <div class="fake-select">
            <?php $action_link = url_for('@search'); ?>
            <?php $sting = $form->getQueryString(); ?>
            <?php $string_find = strripos($sting,'='); ?>
            <select name="page" class="page_selector" onchange="location.href='<?php echo  url_for('@search?'.substr($sting, 0, $string_find).'=') ?>'+jQuery(this).val()">
                <?php for($i=1;$i<=$pager->getLastPage();$i++):?>
                <option value="<?php echo $i ?>" <?php if($i == $pager->getPage()){ echo('selected="selected"'); }?>>
                    <?php echo $i ?>
                </option>
                <?php endfor; ?>
            </select>
            <div class="textfield"></div>
        </div>

    </div>


<?php endif ?>
