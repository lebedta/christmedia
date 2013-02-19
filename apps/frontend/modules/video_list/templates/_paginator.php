<?php if($pager->haveToPaginate()): ?>
    <?php $action_link = urldecode($action_link); ?>

    <?php if(isset($params['name'])): ?>
        <?php $paginate_page = $params['name'] ?>
    <?php else: ?>
        <?php $paginate_page = 'page' ?>
    <?php endif ?>

    <?php if(isset($params['type'])): ?>
        <?php $ancor = $params['type'] ?>
    <?php else: ?>
        <?php $ancor = null ?>
    <?php endif ?>

    <div class="pagination">
        <a href="<?php echo url_for($action_link.'&'.$paginate_page.'='.$pager->getPreviousPage().$ancor);?>" <?php if($pager->getPage() == $pager->getFirstPage()):?>class="unactive"<?php endif; ?>>
            <span><< назад</span>
        </a>

<!--
        <a href="<?php echo url_for($action_link.'&'.$paginate_page.'='.$pager->getFirstPage().$ancor);?>">
            <span>First</span>
        </a>
-->
        <?php foreach($pager->getLinks() as $page):?>

            <?php if($pager->getPage() != $page): ?>
                <a href="<?php echo url_for($action_link.'&'.$paginate_page.'='.$page.$ancor);?>">
                    <span><?php echo($page); ?></span>
                </a>
            <?php else: ?>
                <span><?php echo($page); ?></span>
            <?php endif;?>
        <?php endforeach;?>
<!--
        <a href="<?php echo url_for($action_link.'&'.$paginate_page.'='.$pager->getLastPage().$ancor);?>">
            <span>Last</span>
        </a>
-->
        <a href="<?php echo url_for($action_link.'&'.$paginate_page.'='.$pager->getNextPage().$ancor);?>" <?php if($pager->getPage() == $pager->getLastPage()):?>class="unactive"<?php endif; ?>>
            <span>вперед >></span>
        </a>

        <div class="fake-select">
            <select name="page" class="page_selector" onchange="location.href = '<?php echo url_for($action_link.'&'.$paginate_page.'=');?>'+jQuery(this).val()+'<?php echo $ancor ?>'">
                <?php for($i=1;$i<=$pager->getLastPage();$i++):?>
                    <option value="<?php echo $i ?>" <?php if($i == $pager->getPage()){ echo('selected="selected"'); }?>><?php echo $i ?></option>
                <?php endfor; ?>
            </select>
            <div class="textfield"></div>
        </div>
    </div>
<?php endif; ?>
