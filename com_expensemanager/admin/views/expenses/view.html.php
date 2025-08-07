<?php
/**
 * @package     ExpenseManager
 * @subpackage  Administrator
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

class ExpenseManagerViewExpenses extends JViewLegacy
{
    public $items;
    public $pagination;
    public $state;
    public $filterForm;
    public $activeFilters;

    public function display($tpl = null)
    {
        $this->items         = $this->get('Items');
        $this->pagination    = $this->get('Pagination');
        $this->state         = $this->get('State');
        $this->filterForm    = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }

        $this->addToolbar();
        ExpenseManagerHelper::addSubmenu('expenses');
        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    protected function addToolbar()
    {
        $canDo = ExpenseManagerHelper::getActions();
        $state = $this->get('State');
    
        JToolbarHelper::title(JText::_('COM_EXPENSEMANAGER_EXPENSES_MANAGER'), 'copy'); // Ícone de 'documento'
    
        if ($state->get('filter.published') == -2)
        {
            JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'expenses.delete', 'JTOOLBAR_EMPTY_TRASH');
            JToolbarHelper::publish('expenses.publish', 'JTOOLBAR_PUBLISH', true);
        }
        else
        {
            if ($canDo->get('core.create'))
            {
                JToolbarHelper::addNew('expense.add');
            }
            if (!empty($this->items))
            {
                if ($canDo->get('core.edit'))
                {
                    JToolbarHelper::editList('expense.edit');
                }
                if ($canDo->get('core.edit.state'))
                {
                    JToolbarHelper::publish('expenses.publish', 'JTOOLBAR_PUBLISH', true);
                    JToolbarHelper::unpublish('expenses.unpublish', 'JTOOLBAR_UNPUBLISH', true);
                }
                if ($canDo->get('core.delete'))
                {
                    JToolbarHelper::trash('expenses.trash', 'JTOOLBAR_TRASH');
                }
            }
        }
    
        if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_expensemanager');
        }
    }
}