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

class ExpenseManagerModelExpenses extends JModelList
{
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'published', 'a.published',
                'description', 'a.description',
                'amount', 'a.amount',
                'expense_date', 'a.expense_date',
                'ordering', 'a.ordering',
    
                'consultant_name', 'consultant.name',
                'client_name', 'client.name',
                'category_name', 'category.name'
            );
        }

        parent::__construct($config);
    }

    protected function getListQuery()
    {
        $db    = $this->getDbo();
        $query = $db->getQuery(true);

        $query->select(
            $this->getState(
                'list.select',
                'a.id, a.description, a.amount, a.expense_date, a.invoice_number, a.published, a.ordering, a.checked_out, a.checked_out_time'
            )
        );
        $query->from('#__expensemanager_expenses AS a');

        
        $query->select('consultant.name AS consultant_name');
        $query->join('LEFT', '#__expensemanager_consultants AS consultant ON consultant.id = a.consultant_id');

        $query->select('client.name AS client_name');
        $query->join('LEFT', '#__expensemanager_clients AS client ON client.id = a.client_id');

        $query->select('category.name AS category_name');
        $query->join('LEFT', '#__expensemanager_categories AS category ON category.id = a.category_id');

        $query->select('u.name AS created_by_name');
        $query->join('LEFT', '#__users AS u ON u.id = a.created_by');


        $published = $this->getState('filter.published');
        if (is_numeric($published))
        {
            $query->where('a.published = ' . (int) $published);
        }

        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            if (stripos($search, 'id:') === 0)
            {
                $query->where('a.id = ' . (int) substr($search, 3));
            }
            else
            {
                $search = $db->quote('%' . $db->escape($search, true) . '%');
                $query->where(
                    '(a.description LIKE ' . $search .
                    ' OR consultant.name LIKE ' . $search .
                    ' OR client.name LIKE ' . $search . ')'
                );
            }
        }

        //Lógica para os filtros de dropdown
        $consultantId = $this->getState('filter.consultant_id');
        if (is_numeric($consultantId) && $consultantId > 0) {
            $query->where('a.consultant_id = ' . (int) $consultantId);
        }
        
        $clientId = $this->getState('filter.client_id');
        if (is_numeric($clientId) && $clientId > 0) {
            $query->where('a.client_id = ' . (int) $clientId);
        }
        
        $categoryId = $this->getState('filter.category_id');
        if (is_numeric($categoryId) && $categoryId > 0) {
            $query->where('a.category_id = ' . (int) $categoryId);
        }

        $orderCol  = $this->state->get('list.ordering', 'a.expense_date');
        $orderDirn = $this->state->get('list.direction', 'DESC');
        $query->order($db->escape($orderCol . ' ' . $orderDirn));

        return $query;
    }

    protected function populateState($ordering = 'a.expense_date', $direction = 'desc')
    {
        parent::populateState($ordering, $direction);
        
        $app = JFactory::getApplication();

        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published');
        $this->setState('filter.published', $published);

        $consultantId = $this->getUserStateFromRequest($this->context . '.filter.consultant_id', 'filter_consultant_id');
        $this->setState('filter.consultant_id', $consultantId);
        
        $clientId = $this->getUserStateFromRequest($this->context . '.filter.client_id', 'filter_client_id');
        $this->setState('filter.client_id', $clientId);
        
        $categoryId = $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id');
        $this->setState('filter.category_id', $categoryId);
    }
}