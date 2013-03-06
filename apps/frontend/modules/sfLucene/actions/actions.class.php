<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 - 2008 Carl Vondrick <carl@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once  sfConfig::get('sf_plugins_dir'). '/sfLucenePlugin/modules/sfLucene/lib/BasesfLuceneActions.class.php';

/**
 * @package    sfLucenePlugin
 * @subpackage Module
 * @author     Carl Vondrick <carl@carlsoft.net>
 * @version SVN: $Id: actions.class.php 6247 2007-12-01 03:25:13Z Carl.Vondrick $
 */
class sfLuceneActions extends BasesfLuceneActions
{
  /**
   * Returns an instance of sfLucene configured for this environment.
   */
  protected function getLuceneInstance()
  {
    return sfLuceneToolkit::getApplicationInstance();
  }

    protected function getResults($form)
    {
        $data = $form->getValues();

        $query = new sfLuceneCriteria($this->getLuceneInstance());
        $query->addSane($data['query']);

        if ($data['entity'] != 'all')
        {
            $query->addField($data['entity'], "entity_name");
        }

        if (sfConfig::get('app_lucene_categories', true) && isset($data['category']) && $data['category'] != $this->translate('All'))
        {
            $query->add('sfl_category: ' . $data['category']);
        }

        return new sfLucenePager( $this->getLuceneInstance()->friendlyFind($query) );
    }

    public function executeIndex($request)
    {
        $this->forward($this->getModuleName(), 'search');
    }

    /**
     * Executes the search action.  If there is a search query present in the request
     * parameters, then a search is executed and uses a paged result.  If not, then
     * the search box is displayed to prompt the user to enter controls.
     */
    public function executeSearch($request)
    {
        $this->company = $this->company;
        // determine if the user pressed the "Advanced"  button
        if ($request->getParameter('commit') == $this->translate('Advanced'))
        {
            // user did, so redirect to advanced search
            $this->redirect('@search_advanced');
        }

        $form = new sfLuceneSimpleForm();
        $this->configureCategories($form);
        $form->bind($request->getParameter('form', array()));

        // do we have a query?
        if ($form->isValid())
        {
            $values = $form->getValues();

            // get results
            $pager = $this->getResults($form);

            $num = $pager->getNbResults();

            // were any results returned?
            if ($num > 0)
            {
                // display results
                $pager = $this->configurePager($pager, $form);

                $this->num = $num;
                $this->pager = $pager;
                $this->query = $values['query'];

                $this->form = $form;
                $this->radius=5;

                $this->getContext()->getUser()->setFlash("highlight",$this->query,true);

                $this->setTitleNumResults($pager);

                return 'Results';
            }
            else
            {
                // display error
                $this->form = $form;
                $this->setTitleI18n('No Results Found');

                return 'NoResults';
            }
        }
        else
        {
            // display search controls
            $this->form = $form;
            $this->setTitleI18n('Search');

            return 'Controls';
        }
    }
}