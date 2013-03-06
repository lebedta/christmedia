<?php use_helper('sfLucene', 'I18N') ?>
<span class="spring"></span>
<div class="block-with-list searching-results">
    <h2><?php echo __('Search Results') ?></h2>

    <p><?php echo __('The following results matched your query:') ?></p>

    <?php //include_search_controls($form) ?>
    <?php //include_partial('sfLucene/controls', array('form' => $form, 'company' => $company)); ?>

    <ol start="<?php echo $pager->getFirstIndice() ?>" class="search-results">
      <?php foreach ($pager->getResults() as $result): ?>
        <li><?php include_search_result($result, $query) ?></li>
      <?php endforeach ?>
    </ol>

    <?php //include_search_pager($pager, $form, sfConfig::get('app_lucene_pager_radius', 5)) ?>
    <?php include_partial('sfLucene/pagerNavigation', array('pager' => $pager, 'form' => $form, 'radius' => 5, 'company' => $company)); ?>


</div>