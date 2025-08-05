<?php
/**
 * @package     ExpenseManager
 * @subpackage  Administrator
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

// Proteção contra acesso direto
defined('_JEXEC') or die('Restricted access');

class ExpenseManagerViewClients extends JViewLegacy
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
        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    protected function addToolbar()
    {
        $canDo = ExpenseManagerHelper::getActions();
        $user  = JFactory::getUser();

        JToolbarHelper::title(JText::_('COM_EXPENSEMANAGER_CLIENTS_MANAGER'), 'folder');

        if ($canDo->get('core.create'))
        {
            JToolbarHelper::addNew('client.add');
        }

        if (!empty($this->items))
        {
            if ($canDo->get('core.edit'))
            {
                JToolbarHelper::editList('client.edit');
            }

            if ($canDo->get('core.edit.state'))
            {
                JToolbarHelper::publish('clients.publish', 'JTOOLBAR_PUBLISH', true);
                JToolbarHelper::unpublish('clients.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            }

            if ($canDo->get('core.delete'))
            {
                JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'clients.delete', 'JTOOLBAR_DELETE');
            }
        }

        if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_expensemanager');
        }

        JHtmlSidebar::setAction('index.php?option=com_expensemanager&view=clients');

        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_PUBLISHED'),
            'filter_published',
            JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
        );
    }

    /**
     * Retorna os campos de ordenação para o layout de searchtools.
     *
     * @return  array  Um array de campos pelos quais a lista pode ser ordenada.
     */
    protected function getSortFields()
    {
        return array(
            'a.ordering'    => JText::_('JGRID_HEADING_ORDERING'),
            'a.published'   => JText::_('JSTATUS'),
            'a.name'        => JText::_('COM_EXPENSEMANAGER_CLIENT_NAME'),
            'a.client_type' => JText::_('COM_EXPENSEMANAGER_CLIENT_TYPE'),
            'a.cnpj'        => JText::_('COM_EXPENSEMANAGER_CLIENT_CNPJ'),
            'a.city_id'     => JText::_('COM_EXPENSEMANAGER_CLIENT_CITY'),
            'a.id'          => JText::_('JGRID_HEADING_ID')
        );
    }
}