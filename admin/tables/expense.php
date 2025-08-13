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

class ExpenseManagerTableExpense extends JTable
{
    public function __construct($db)
    {
        parent::__construct('#__expensemanager_expenses', 'id', $db);
        
        $this->_trackAssets = false;
    }

    public function check()
    {
        $this->invoice_number = trim($this->invoice_number);
        $this->notes = trim($this->notes);
        $this->description = trim($this->description);

        if (empty($this->consultant_id) || (int) $this->consultant_id <= 0)
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_EXPENSE_CONSULTANT_ID_REQUIRED'));
            return false;
        }
    
        if (empty($this->client_id) || (int) $this->client_id <= 0)
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_EXPENSE_CLIENT_ID_REQUIRED'));
            return false;
        }
    
        if (empty($this->category_id) || (int) $this->category_id <= 0)
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_EXPENSE_CATEGORY_ID_REQUIRED'));
            return false;
        }
    
        if (empty($this->description))
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_EXPENSE_DESCRIPTION_REQUIRED'));
            return false;
        }
    
        if (!is_numeric($this->amount) || (float) $this->amount <= 0.00)
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_EXPENSE_AMOUNT_INVALID'));
            return false;
        }
    
        if (empty($this->expense_date) || $this->expense_date == $this->_db->getNullDate())
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_EXPENSE_DATE_REQUIRED'));
            return false;
        }
    
        return true;
    }

    public function store($updateNulls = true)
    {
        $date = JFactory::getDate();
        $user = JFactory::getUser();

        if (empty($this->id))
        {
            $this->created = $date->toSql();
            $this->created_by = $user->get('id');
        }

        $this->modified = $date->toSql();
        $this->modified_by = $user->get('id');

        if (!isset($this->published))
        {
            $this->published = 1;
        }

        return parent::store($updateNulls);
    }

    public function delete($pk = null)
    {
        return parent::delete($pk);
    }
}