<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class ExpensemanagerViewTechnicalvisits extends JViewLegacy
{
    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        $this->_preparePagination();

        $doc = JFactory::getDocument();
        $doc->addStyleSheet(JUri::root() . 'components/com_expensemanager/assets/css/style.css');

        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

        parent::display($tpl);
    }

    private function _preparePagination()
    {
        if ($this->pagination->pagesTotal <= 1) {
            return;
        }

        $limit      = $this->pagination->limit;
        $limitstart = $this->pagination->limitstart;
        $baseUrl    = JUri::getInstance()->toString(['scheme', 'host', 'port', 'path']);
        $query      = JFactory::getApplication()->input->getArray($_GET);
        unset($query['limitstart']);

        $query['limitstart'] = max(0, $limitstart - $limit);
        $this->prevUrl = $baseUrl . '?' . http_build_query($query);

        $query['limitstart'] = $limitstart + $limit;
        $this->nextUrl = $baseUrl . '?' . http_build_query($query);
    }

}